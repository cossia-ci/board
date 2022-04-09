<?php
use App\Models\BaseModel;
use CodeIgniter\I18n\Time;
if(! function_exists('camel_case'))
{
    function camel_case($value) : string
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        return lcfirst(str_replace(' ', '', $value));
    }
}

if(! function_exists('snake_case'))
{
    function snake_case($value) : string
    {
        if (ctype_lower($value)) return $value;
        $value = preg_replace('/[\s]+/u', '', ucwords( str_replace( '-','_',$value ) ) );
        return mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1_', $value), 'UTF-8');
    }
}

if(! function_exists('studly_case'))
{
    function studly_case($value) : string
    {
        return ucwords(camel_case($value));
    }
}

if(! function_exists('per_page'))
{
    function per_page($perPage = 10) : string
    {
		$perPage_ = [];
        foreach($_GET as $key => $val){
            if($key != 'perPage' && $key != 'page'){
                if( is_array($val) ) foreach($val as $v) $perPage_[] = $key.'[]='.$v;
                else $perPage_[] = $key.'='.$val;
            }
        }
		$pagging = [5, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 200, 300, 400, 500];
		$html = '<select name="perPage" onChange="javascript:location.href=\'?'.implode('&',$perPage_).'&perPage=\'+this.value">';
		foreach($pagging as $row){
			$selected = ( $row == $perPage ) ? 'selected' : '';
			$html .= '<option value="'.$row.'" '.$selected.'>'.$row.'개 보기</option>';
		}
		$html .= '</select>';
		return $html;
	}
}

if(! function_exists('is_login')){
    function is_login() : bool
	{
		$data = false;
		$session = session();
		if( $session->has('is_member') && $session->is_member === true ) $data = true;
		return $data;
	}
}

if(! function_exists('view_ip')){
	function view_ip( $ip_ ) : string
	{
		$arr = explode( '.', $ip_ );
		$ip = $arr[0]??'♡';
		$ip .= '.♡.';
		$ip .= $arr[2]??'♡';
		$ip .= '.♡';
		return $ip;
	}
}

if(! function_exists('is_admin')){
    function is_admin() : bool
	{
		$data = false;
		$session = session();
		if( $session->has('is_manager') && $session->is_manager === true ) $data = true;
		return $data;
	}
}

if(! function_exists('get_config_data')){
    function get_config_data( string $group = '', string $code = '') : array
	{
		$model = new BaseModel('co_config');
		$data = $model->where(['group'=>$group, 'code'=>$code])->first();
		return $data??[];
	}
}

if(! function_exists('get_board_type')){
    function get_board_type( string $key = '' ) // : array | string
	{
		$type = [
			'default'=>'일반',
			'gallery'=>'갤러리',
			'event'=>'이벤트',
			'youtube'=>'유튜브',
			'write'=>'쓰기전용'
		];
		return ($key) ? $type[$key] : $type;
	}
}

if(! function_exists('get_board_auth')){
    function get_board_auth( string $key = '' ) : string
	{
		$type = [
			'n'=>'사용안함',
			'all'=>'전체(회원+비회원)',
			'mem'=>'회원전용',
			'adm'=>'관리자전용',
			'sps'=>'특정회원등급'
		];
		return $type[$key];
	}
}

if(! function_exists('get_infos_arr')){
    function get_infos_arr() : array
	{
		return [
			'company'=>'회사소개',
			'tos'=>'이용약관',
			'privacy'=>'개인정보처리방침',
			'email'=>'이메일 수집 거부',
			'agreement'=>'개인정보수집 동의항목',
		];
	}
}

if(! function_exists('get_infos_nav')){
    function get_infos_nav( string $key = '' )
	{
		$data = [
				'tos'=>'이용약관',
				'privacy'=>'개인정보처리방침',
				'email'=>'이메일 수집 거부',
		];
		return $key != '' ? $data[$key] : $data;
	}
}

if(! function_exists('get_youtube_id')){
    function get_youtube_id( string $url ) : string
	{
		$arr = explode('/', $url);
		return end($arr);
	}
}

if(! function_exists('get_youtube_thumb')){
    function get_youtube_thumb( string $url ) : string
	{
		return 'http://img.youtube.com/vi/'.get_youtube_id($url).'/mqdefault.jpg';
	}
}

if(! function_exists('get_url_param')){
    function get_url_param() : string
	{
		$arr = explode( '?', $_SERVER['REQUEST_URI'] );
		return str_replace( '/'.uri_string(), '', end($arr));
	}
}

if(! function_exists('get_count_table')){
    function get_count_table( string $table ) : int
	{
		$db = db_connect();
		if( $this->db->tableExists($table) ){
			$builder = $db->table($table)->selectCount('ano')->where('`delDt` IS NULL', null, false);
			$data = $builder->get()->getResult('array')[0];
		}
		return $data['ano']??0;
	}
}

if(! function_exists('get_member_level')){
    function get_member_level( string $level ) : string
	{
		$model = new BaseModel('co_memberLevel');
		return $model->select('name')->where('level', $level)->first()['name'];
	}
}

if(! function_exists('is_new')){
    function is_new( $reg, $cfg ) : string
	{
		$now = new Time( '+'.$cfg.' hours' );
		$write = Time::parse( $reg );
		return $write->isBefore($now) ? '<i class="fad fa-sparkles board-new"></i>' : '';
	}
}

if(! function_exists('is_hot')){
    function is_hot( $hit, $cfg ) : string
	{
		return $hit >= $cfg ? '<i class="fad fa-pepper-hot board-hot"></i>' : '';
	}
}

if(! function_exists('get_table_some')){
    function get_table_some( string $table, int $limit = 6 ) : array
	{
		$model = new BaseModel('co_'.$table);
		$data = $model->orderBy('ano DESC')->findAll($limit);
		return $data;
	}
}

if(! function_exists('get_member_email')){
    function get_member_email( int $ano ) : string
	{
		$model = new BaseModel('co_member');
		$data = $model->find($ano);
		$id = get_config_data('member', 'join')['data']['id']??'';
		if( $id == 'email' ) $email = $data['id'];
		else $email = $data['personal']['email'];
		return preg_replace("/\s+/", "", $email);
	}
}


