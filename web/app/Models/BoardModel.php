<?php
namespace App\Models;
use App\Database\DBTableField;
class BoardModel extends \CodeIgniter\Model
{
    protected $table				= '';
    protected $primaryKey			= '';
    protected $useAutoIncrement		= false;
	protected $tempReturnType		= 'array';
    protected $returnType           = 'array';
    protected $useSoftDeletes		= true;
    protected $allowedFields		= [];
    protected $useTimestamps		= true;
    protected $createdField			= 'regDt';
    protected $updatedField			= 'editDt';
    protected $deletedField			= 'delDt';
    protected $validationRules		= [];
    protected $jsonField    		= [];
    protected $enumField    		= [];
    protected $validationMessages	= [];
    protected $skipValidation		= false;
    protected $afterFind		    = ['jsonToArray'];
    protected $beforeFind           = [];
    protected $beforeInsert         = ['getSorts'];
    protected $afterInsert          = ['updateFamily'];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    public function __construct(string $code, string $type = 'board')
    {
        parent::__construct();
        if($type == 'board'){
			$this->table = 'co_bd_'.$code;
			$this->fields = DBTableField::board();
		}else{
			$this->table = 'co_cmt_'.$code;
			$this->fields = DBTableField::comment();
		}

		if( is_array($this->fields) )
			foreach( $this->fields as $key => $row ){
                if( isset($row['auto_increment']) && $row['auto_increment'] === true ){
                    $this->primaryKey = $key;
                    $this->useAutoIncrement = true;
                } else if ( isset($row['primaryKey']) && $row['primaryKey'] === true ) {
                    $this->primaryKey = $key;
                } else if ( $key != 'regDt' && $key != 'editDt' ) {
                    $this->allowedFields[] = $key;
                }
                if( $row['type'] == 'json' ) $this->jsonField[] = $key;
                if( $row['type'] == 'enum' ) $this->enumField[$key] = $row['default'];
            }
        
        if( !$this->db->tableExists($this->table) ) $this->create_table();
    }

    public function create_table()
    {
        $forge = \Config\Database::forge();
        $forge->addField($this->fields)->addPrimaryKey($this->primaryKey);
        foreach( $this->fields as $key => $row )
            if( isset($row['key']) && $row['key'] === true ) 
                $forge->addKey($key);
        $forge->createTable($this->table, false, ['ENGINE' => 'InnoDB']);
    }

    public function jsonToArray(array $data) : array
    {
        if( isset($data['data']) )
            foreach($data['data'] as $key => $val)
                if( is_array($val) ){
                    foreach( $val as $k_ => $v_ ){
                        if( in_array($k_, $this->jsonField) ) $data['data'][$key][$k_] = json_decode($v_, true);
                    }
                }else{
                    if( in_array($key, $this->jsonField) ) $data['data'][$key] = json_decode($val, true);
                }
        return $data;
    }

    public function save($data): bool
    {
        if( is_array($data) )
            foreach($data as $key => $val){
                if( in_array($key, $this->jsonField) ){
                    $data[$key] = json_encode($val, JSON_UNESCAPED_UNICODE|JSON_NUMERIC_CHECK);
                }
            }
		if( is_array($this->enumField) && count( $this->enumField ) ){
			foreach( $this->enumField as $key => $val ){
				$data[$key] = $data[$key]??$val;
			}
		}
        return parent::save($data);
    }

    public function setLimt( int $limt = 0 )
    {
        $this->perPage = $limt != 0 ? $limt : $_GET['perPage'];
        return $this;
    }

    public function setWhere( array $param )
    {
        if( isset($param['keyword']) && $param['keyword'] )
            $this->like($param['key'], $param['keyword']);
        if( isset($param['horse']) && $param['horse'] )
            $this->where('horse', $param['horse']);
        if( isset($param['sDate']) && $param['sDate'] )
            $this->where('DATE(regDt) >= ', $param['sDate']);
        if( isset($param['eDate']) && $param['eDate'] )
            $this->where('DATE(regDt) <= ', $param['eDate']);
        return $this;
    }

    public function getList() : array
    {
        $data = $this->orderBy('`family` DESC, `sorts` ASC, `depth` ASC')->paginate($this->perPage);
        return ['data'=>$data, 'page'=>$this->pager, 'no' => get_count_table( $this->table ) - ( $_GET['page'] - 1 ) * $this->perPage];
    }

    public function complete_deletion()
    {
        $this->useSoftDeletes = false;
        return $this;
    }

    public function getSorts($data)
	{
		if( isset($data['data']['parent']) && $data['data']['parent'] != '' ){
			$parent = $this->select(['family', 'sorts', 'depth'])->find($data['data']['parent']);
			$sorts = $this->select('IFNULL( MIN( `sorts` ), 0 ) AS `sorts`', null, false)->where(['family'=>$parent['family'], 'sorts > '=>$parent['sorts'], 'depth <= '=>$parent['depth']])->first()['sorts'];
            if($sorts){		// 0이 아닐경우
				$this->set( '`sorts` = ( `sorts` + 1 )', null, false )->where(['family'=>$parent['family'], 'sorts >= '=>$parent['sorts'], 'depth <= '=>$parent['depth']])->update();
                $data['data']['family'] = $parent['family'];
                $data['data']['depth'] = ++$parent['depth'];
                $data['data']['sorts'] = $sorts;
            }else{		// 0일 경우
				$sorts = $this->select( 'IFNULL( MAX( `sorts` ), 0 ) + 1 AS `sorts`', null, false )->where(['family'=>$parent['family']])->first()['sorts'];
                $data['data']['family'] = $parent['family'];
                $data['data']['depth'] = ++$parent['depth'];
                $data['data']['sorts'] = $sorts;
			}
		} else {
            $data['data']['family'] = 0;
            $data['data']['depth'] = 0;
            $data['data']['sorts'] = 0;
        }
		return $data;
	}
	
	public function updateFamily( $data )
	{
		if( $data['data']['family'] == 0 ) $this->save(['family'=>$data['id'], 'ano'=>$data['id']]);
	}
}