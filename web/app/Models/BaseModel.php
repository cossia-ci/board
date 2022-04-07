<?php
namespace App\Models;
use App\Database\DBTableField;
use App\Models\AuthModel;
class BaseModel extends \CodeIgniter\Model
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
    protected $pointField    		= [];
    protected $validationMessages	= [];
    protected $skipValidation		= false;
    protected $afterFind		    = ['jsonToArray'];
    protected $beforeFind           = [];
    protected $beforeInsert         = ['hashPassword'];
//    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = ['hashPassword'];
//    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    public function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && $data['data']['password'] ) 
            $data['data']['password'] = AuthModel::make_hash( $data['data']['password'] );
        return $data;
    }

    public function __construct(string $table)
    {
        parent::__construct();
        $this->table = $table;
        $this->fields = DBTableField::$table();
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
                if( $row['type'] == 'point' ) $this->pointField[] = $key;
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
                if( in_array($key, $this->pointField) ){
					if( $val ){
						$this->set($key, 'ST_GeomFromText(\'POINT('.$val.')\')', false);
						unset($data[$key]);
					}
				}
            }
		if( is_array($this->enumField) && count( $this->enumField ) ){
			foreach( $this->enumField as $key => $val ){
				$data[$key] = $data[$key]??$val;
			}
		}
        return parent::save($data);
    }

    public function complete_deletion()
    {
        $this->useSoftDeletes = false;
        return $this;
    }
}