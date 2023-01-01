<?php
use App\Models\BaseModel;
use CodeIgniter\I18n\Time;
if( !function_exists('per_page') )
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

if( !function_exists('is_login') )
{
    function is_login() : bool
	{
		$data = false;
		$session = session();
		if( $session->has('is_member') && $session->is_member === true ) $data = true;
		return $data;
	}
}

if( !function_exists('view_ip') )
{
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

if( !function_exists('is_admin') )
{
    function is_admin() : bool
	{
		$data = false;
		$session = session();
		if( $session->has('is_manager') && $session->is_manager === true ) $data = true;
		return $data;
	}
}

if( !function_exists('get_config_data') )
{
    function get_config_data( string $group = '', string $code = '') : array
	{
		$model = new BaseModel('co_config');
		$data = $model->where(['group'=>$group, 'code'=>$code])->first();
		return $data??[];
	}
}

if( !function_exists('get_board_type') )
{
    function get_board_type( string $key = null ) : string|array
	{
		$type = [
			'default'=>'일반',
			'gallery'=>'갤러리',
			'event'=>'이벤트',
			'youtube'=>'유튜브',
			'write'=>'쓰기전용'
		];
		return $key ? $type[ $key ] : $type;
	}
}

if( !function_exists('get_board_auth') )
{
    function get_board_auth( string $key = null ) : string|array
	{
		$type = [
			'n'=>'사용안함',
			'all'=>'전체(회원+비회원)',
			'mem'=>'회원전용',
			'adm'=>'관리자전용',
			'sps'=>'특정회원등급'
		];
		return $key ? $type[$key] : $type;
	}
}

if( !function_exists('get_infos_arr') )
{
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


if( !function_exists('get_infos_nav') )
{
    function get_infos_nav( string $key = null )
	{
		$data = [
				'tos'=>'이용약관',
				'privacy'=>'개인정보처리방침',
				'email'=>'이메일 수집 거부',
		];
		return $key ? $data[$key] : $data;
	}
}

# 유튜브 ID return
if( !function_exists('get_youtube_id') )
{
    function get_youtube_id( string $url ) : string
	{
		$arr = explode('/', $url);
		return end($arr);
	}
}

# 유튜브 썸네일 주소 return
if( !function_exists('get_youtube_thumb') )
{
    function get_youtube_thumb( string $url ) : string
	{
		return 'http://img.youtube.com/vi/'.get_youtube_id($url).'/mqdefault.jpg';
	}
}

# get으로 받은 파라미터 return
if( !function_exists('get_url_param') )
{
    function get_url_param() : string
	{
		$arr = explode( '?', $_SERVER['REQUEST_URI'] );
		return str_replace( '/'.uri_string(), '', end($arr));
	}
}

# table 전체 row return
if( !function_exists('get_count_table') )
{
    function get_count_table( string $table ) : int
	{
		$db = db_connect();
		if( $db->tableExists($table) ){
			$builder = $db->table($table)->selectCount('ano')->where('`delDt` IS NULL', null, false);
			$data = $builder->get()->getResult('array')[0];
		}
		return $data['ano']??0;
	}
}

# 회원 level return
if( !function_exists('get_member_level') )
{
    function get_member_level( string $level ) : string
	{
		$model = new BaseModel('co_memberLevel');
		return $model->select('name')->where('level', $level)->first()['name'];
	}
}

# 게시글 New return
if( !function_exists('is_new') )
{
    function is_new( $reg, $cfg ) : string
	{
		$now = new Time();
		$write = Time::parse( $reg )->addHours($cfg);
		return $write->isBefore($now) ?  '' : '<i class="xi-new"></i>';
	}
}

# 게시글 Hot return
if( !function_exists('is_hot') )
{
    function is_hot( $hit, $cfg ) : string
	{
		return $hit >= $cfg ? '<i class="xi-hot"></i>' : '';
	}
}

# table return
# index 게시글 보여주기 비슷
if( !function_exists('get_table_some') )
{
    function get_table_some( string $table, int $limit = 6 ) : array
	{
		$model = new BaseModel('co_'.$table);
		$data = $model->orderBy('ano DESC')->findAll($limit);
		return $data;
	}
}

# 회원 email return
if( !function_exists('get_member_email') )
{
    function get_member_email( int $ano ) : string
	{
		$model = new BaseModel('co_member');
		$data = $model->find($ano);
		$id = get_config_data('member', 'join')['data']['id']??'';
		if( $id == 'email' ) $email = $data['id'];
		else $email = $data['info']['email'];
		return $email ? preg_replace("/\s+/", "", $email) : '';
	}
}

# 게시판 editor script 포함 return 
if( !function_exists('set_editor') )
{
    function set_editor( string $name, string $data = null, string $id = null ) : string
	{
		helper('inflector');
		$id ??= $name;
		$text = '<textarea name="'.$name.'" id="'.camelize($id).'">'.$data.'</textarea>'.PHP_EOL;
		$text .= '<script>'.PHP_EOL;
		$text .= 'const '.camelize($id).' = CKEDITOR.replace(\''.camelize($id).'\',editor_param);'.PHP_EOL;
		$text .= camelize($id).'.on("mode", function(){'.PHP_EOL;
		$text .= 'if ( this.mode == "source" ) {'.PHP_EOL;
		$text .= 'const editable = '.camelize($id).'.editable();'.PHP_EOL;
		$text .= 'editable.attachListener(editable,"input",function() {'.PHP_EOL;
		$text .= 'editable.setData(anti_xss(editable.getData()));'.PHP_EOL;
		$text .= '});'.PHP_EOL;
		$text .= '}'.PHP_EOL;
		$text .= '})'.PHP_EOL;
		$text .= '</script>'.PHP_EOL;
		return $text;
	}
}

# 전화번호 - 포함 return
if( !function_exists('phone_with_hyphen') )
{
    function phone_with_hyphen( string $phone = null ) : string
	{
		return preg_replace( "/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", phone_without_hyphen( $phone ) );
	}
}

# 전화번호 - 제거 return
if( !function_exists('phone_without_hyphen') )
{
    function phone_without_hyphen( string $phone = null ) : string
	{
		return str_replace(['-', ' '], '', $phone);
	}
}

# 게시글 중 script 부분 삭제 return - 미사용 -
if( !function_exists('view_content') )
{
    function view_content( string $text = '' ) : string
	{
		return preg_replace('!<script(.*?)<\/script>!is','',$text);
	}
}

# 회원 가입경로 return
if( !function_exists('get_login_channel') )
{
    function get_login_channel( string $code = null ) : string|array
	{
		$arr = [
			'naver' => '네이버',
			'kakao' => '카카오',
			'self' => '자사',
		];
		return $code ? $arr[ $code ] : $arr;
	}
}

# 입력날짜의 요일 return
if( !function_exists('get_week_name') )
{
    function get_week_name( string $date ) : string
	{
		$week = ['일','월','화','수','목','금','토'];
		return $week[ date( 'w', strtotime( $date ) ) ];
	}
}

# 기간 format에 맞춰 return
if( !function_exists('get_period') )
{
    function get_period( string $sdate, string $edate, bool $week = false, string $format = 'Y.m.d' ) : string
	{
		$sdate = Time::parse( $sdate );
		$edate = Time::parse( $edate );
		if( $sdate->getYear() == $edate->getYear() ){
			if( $sdate->getMonth() == $edate->getMonth() ) $endformat = substr($format, 4);
			else $endformat = substr($format, 2);
		}else{
			$endformat = $format;
		}
		$return[0] = date($format, strtotime($sdate));
		$return[0] .= $week ? ' '.get_week_name($sdate, '()') : '';
		
		$return[1] = date($endformat, strtotime($edate));
		$return[1] .= $week ? ' '.get_week_name($edate, '()') : '';
		return implode( ' ~ ', $return );
	}
}

# 회사소개 및 치환문자 return
if( !function_exists('get_change_word') )
{
    function get_change_word() : array
	{
		$data = get_config_data('config','info')['data']??'';
        return [
            'company'=> $data['company']['name']??'company',
            'private_name' => $data['private']['name']??'private_name',
            'private_position' => $data['private']['position']??'private_position',
            'private_tel' => $data['private']['tel']??'private_tel',
            'private_email' => $data['private']['email']??'private_email',
        ];
	}
}

# default.html 입력받아 default 를 return
if( !function_exists('get_exp_word') )
{
    function get_exp_word( string $text, string $ass = '.', int $turn = 0  ) : string
	{
		$arr = explode( $ass, $text );
		return $arr[ $turn ];
	}
}

# 다국어 select 값들
if( !function_exists('get_language') )
{
    function get_language() : array
	{
		$arr = [
			'ko' => '한국어',
			'en' => 'English',
			'ru' => 'Русский',
		];
		return $arr;
	}
}

