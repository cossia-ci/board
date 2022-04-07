<?php
namespace App\Database;
class DBTableField
{
    public static function co_manager() : array
    {
        $fields = [
            'ano' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true,],
            'email' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment'=>'아이디', 'key'=>true],
            'password' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment'=>'비밀번호',],
            'level' => ['type' => 'tinyint', 'constraint' => 3, 'default' => 1, 'comment'=>'등급',],
            'photo' => ['type' => 'json', 'null' => true, 'comment'=>'이미지',],
            'info' => ['type' => 'json', 'null' => true, 'comment'=>'정보',],
            'auth' => ['type' => 'json', 'null' => true, 'comment'=>'권한',],
            'regDt' => ['type' => 'datetime','null' => true, 'comment'=>'등록일',],
            'editDt' => ['type' => 'datetime', 'null' => true, 'comment'=>'수정일',],
            'delDt' => ['type' => 'datetime','null' => true, 'comment'=>'삭제일',],
        ];
        return $fields;
    }

    public static function co_config() : array
    {
        $fields = [
            'ano' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true,],
            'group' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
            'code' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
            'data' => ['type' => 'json', 'null' => true,],
            'regDt' => ['type' => 'datetime','null' => true, 'comment'=>'등록일',],
            'editDt' => ['type' => 'datetime', 'null' => true, 'comment'=>'수정일',],
            'delDt' => ['type' => 'datetime','null' => true, 'comment'=>'삭제일',],
        ];
        return $fields;
    }

    public static function co_member() : array
    {
        $fields = [
            'ano' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true,],
            'id' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment'=>'아이디', 'key'=>true],
            'password' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment'=>'비밀번호',],
            'level' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'comment'=>'등급번호',],
            'app' => ['type' => 'enum', 'constraint' => ['y','n'], 'default' => 'n', 'comment'=>'승인여부',],
            'info' => ['type' => 'json', 'null' => true, 'comment'=>'기본정보',],
            'biz' => ['type' => 'json', 'null' => true, 'comment'=>'사업자정보',],
            'etc' => ['type' => 'json', 'null' => true, 'comment'=>'부가정보',],
            'memo' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment'=>'관리자메모'],
            'regDt' => ['type' => 'datetime','null' => true, 'comment'=>'등록일',],
            'editDt' => ['type' => 'datetime', 'null' => true, 'comment'=>'수정일',],
            'delDt' => ['type' => 'datetime','null' => true, 'comment'=>'삭제일',],
        ];
        return $fields;
    }

    public static function co_memberLevel() : array
    {
        $fields = [
            'ano' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true,],
            'level' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'comment'=>'등급',],
            'name' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment'=>'등급명'],
            'info' => ['type' => 'json', 'null' => true, 'comment'=>'기본정보',],
            'regDt' => ['type' => 'datetime','null' => true, 'comment'=>'등록일',],
            'editDt' => ['type' => 'datetime', 'null' => true, 'comment'=>'수정일',],
            'delDt' => ['type' => 'datetime','null' => true, 'comment'=>'삭제일',],
        ];
        return $fields;
    }

    public static function co_popup() : array
    {
        $fields = [
            'ano' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true,],
            'title' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
            'type' => ['type' => 'enum', 'constraint' => ['h','l'], 'default' => 'l',],
            'isView' => ['type' => 'enum', 'constraint' => ['y','n'], 'default' => 'y',],
            'sDate' => ['type' => 'date','null' => true,'default' => '0000-00-00',],
            'eDate' => ['type' => 'date','null' => true,'default' => '0000-00-00',],
            'sTime' => ['type' => 'time','null' => true,'default' => '00:00:00',],
            'eTime' => ['type' => 'time','null' => true,'default' => '00:00:00',],
            'viewToday' => ['type' => 'enum', 'constraint' => ['y','n'], 'default' => 'y',],
            'page' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
            'param' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
            'width' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0,],
            'height' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0,],
            'top' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0,],
            'left' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0,],
            'content' => ['type' => 'text', 'null' => true,],
            'regDt' => ['type' => 'datetime','null' => true,],
            'editDt' => ['type' => 'datetime', 'null' => true,],
            'delDt' => ['type' => 'datetime','null' => true,],
        ];
        return $fields;
    }

    public static function co_banner() : array
    {
        $fields = [
            'ano' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true,],
            'title' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'key' => true,],
            'code' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'unique' => true],
            'speed' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 300, ],
            'time' => ['type' => 'TINYINT', 'constraint' => 3, 'unsigned' => true, 'default' => 1, ],
            'effect' => ['type' => 'varchar', 'constraint' => 20, 'null' => true],
            'pagination' => ['type' => 'enum', 'constraint' => ['y','n'], 'default' => 'y',],
            'buttons' => ['type' => 'enum', 'constraint' => ['y','n'], 'default' => 'y',],
            'width' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0, ],
            'widthType' => ['type' => 'enum', 'constraint' => ['px','%'], 'default' => 'px',],
            'height' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0, ],
            'data' => ['type' => 'json', 'null' => true,],
            'regDt' => ['type' => 'datetime','null' => true,],
            'editDt' => ['type' => 'datetime', 'null' => true,],
            'delDt' => ['type' => 'datetime','null' => true,],
        ];
        return $fields;
    }

    public static function co_board_list() : array
	{
		$fields = [
            'ano' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true,],
            'code' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
            'name' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
            'type' => ['type' => 'varchar', 'constraint' => 10, 'null' => true,],
            'skin' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
            'item' => ['type' => 'json', 'null' => true,],
            'basic' => ['type' => 'text', 'null' => true,],
            'auth' => ['type' => 'json', 'null' => true,],
            'list' => ['type' => 'json', 'null' => true,],
            'write' => ['type' => 'json', 'null' => true,],
            'outline' => ['type' => 'json', 'null' => true,],
            'regDt' => ['type' => 'datetime','null' => true,],
            'editDt' => ['type' => 'datetime', 'null' => true,],
            'delDt' => ['type' => 'datetime','null' => true,],
        ];
        return $fields;
	}

    public static function board() : array
    {
        $fields = [
            'ano' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true,],
            'parent' => ['type'=>'int', 'constraint'=>11, 'unsigned'=>true, 'default'=>0],
            'family' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0,],
            'sorts' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0,],
            'depth' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0,],
            'is_notice' => ['type' => 'enum', 'constraint' => ['y','n'], 'default' => 'n',],
            'is_secret' => ['type' => 'enum', 'constraint' => ['y','n'], 'default' => 'n',],
            'pw' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
            'file' => ['type' => 'json', 'null' => true,],
            'thumbnail' => ['type' => 'json', 'null' => true,],
            'user_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default'=>0],
            'admin_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default'=>0],
            'writer' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
            'horse' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
			'title' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'key'=>true],
            'youtube' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
			'content' => ['type' => 'text', 'null' => true,],
			'etc' => ['type' => 'json', 'null' => true,],
            'sdate' => ['type' => 'date','null' => true,],
            'edate' => ['type' => 'date','null' => true,],
            'hit' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0,],
            'ip' => ['type' => 'varchar', 'constraint' => 20, 'null' => true,],
            'regDt' => ['type' => 'datetime','null' => true,],
            'editDt' => ['type' => 'datetime', 'null' => true,],
            'delDt' => ['type' => 'datetime','null' => true,],
        ];
        return $fields;
    }

    public static function comment() : array
    {
        $fields = [
            'ano' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true,],
            'parent' => ['type'=>'int', 'constraint'=>11, 'unsigned'=>true, 'default'=>0],
            'family' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0,],
            'sorts' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0,],
            'depth' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0,],
            'bdano' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0,'key'=>true],
            'user_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default'=>0],
            'admin_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default'=>0],
            'writer' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
            'comment' => ['type' => 'text', 'null' => true,],
            'ip' => ['type' => 'varchar', 'constraint' => 20, 'null' => true,],
            'regDt' => ['type' => 'datetime','null' => true,],
            'editDt' => ['type' => 'datetime', 'null' => true,],
            'delDt' => ['type' => 'datetime','null' => true,],
        ];
        return $fields;
    }

    public static function co_admin_menu() : array
    {
        $fields = [
            'ano' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true,],
            'parent' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => false, 'default' => 0, 'comment'=>'부모번호', 'key'=>true,],
            'sort' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => false, 'default' => 0, 'comment'=>'정렬순서', 'key'=>true,],
            'icons' => ['type' => 'varchar', 'constraint' => 100, 'null' => true, 'comment'=>'아이콘',],
            'type' => ['type' => 'varchar', 'constraint' => 20, 'null' => true, 'comment'=>'타입',],
            'code' => ['type' => 'varchar', 'constraint' => 30, 'null' => true, 'comment'=>'코드',],
			'name' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment'=>'메뉴이름',],
            'folder' => ['type' => 'varchar', 'constraint' => 30, 'null' => true, 'comment'=>'폴더',],
            'controller' => ['type' => 'varchar', 'constraint' => 80, 'null' => true, 'comment'=>'컨트롤러',],
			'class' => ['type' => 'varchar', 'constraint' => 80, 'null' => true, 'comment'=>'클래스',],
            'isView' => ['type' => 'enum', 'constraint' => ['y','n'], 'default' => 'y', 'comment'=>'노출여부',],
            'regDt' => ['type' => 'datetime','null' => true, 'comment'=>'등록일',],
            'editDt' => ['type' => 'datetime', 'null' => true, 'comment'=>'수정일',],
            'delDt' => ['type' => 'datetime','null' => true, 'comment'=>'삭제일',],
        ];
        return $fields;
    }
    
    public static function co_front_menu() : array
    {
        $fields = [
            'ano' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true,],
            'parent' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => false, 'default' => 0, 'comment'=>'부모번호', 'key'=>true,],
            'sort' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => false, 'default' => 0, 'comment'=>'정렬순서', 'key'=>true,],
            'isView' => ['type' => 'enum', 'constraint' => ['y','n'], 'default' => 'y', 'comment'=>'노출여부',],
            'type' => ['type' => 'varchar', 'constraint' => 10, 'null' => true, 'comment'=>'타입',],
            'name' => ['type' => 'varchar', 'constraint' => 255, 'null' => true, 'comment'=>'메뉴이름',],
            'link' => ['type' => 'varchar', 'constraint' => 50, 'null' => true, 'comment'=>'연결페이지',],
            'landPage' => ['type' => 'varchar', 'constraint' => 10, 'null' => true, 'comment'=>'렌딩페이지',],

            'folder' => ['type' => 'varchar', 'constraint' => 30, 'null' => true, 'comment'=>'폴더',],
            'controller' => ['type' => 'varchar', 'constraint' => 80, 'null' => true, 'comment'=>'컨트롤러',],
			'class' => ['type' => 'varchar', 'constraint' => 80, 'null' => true, 'comment'=>'클래스',],

            'regDt' => ['type' => 'datetime','null' => true, 'comment'=>'등록일',],
            'editDt' => ['type' => 'datetime', 'null' => true, 'comment'=>'수정일',],
            'delDt' => ['type' => 'datetime','null' => true, 'comment'=>'삭제일',],
        ];
        return $fields;
    }

    public static function co_qna() : array
	{
		$fields = [
            'ano' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true,],
			'user_id' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
            'etc' => ['type' => 'json', 'null' => true,],
			'title' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
			'question' => ['type' => 'text', 'null' => true,],
			'quesFile' => ['type' => 'json', 'null' => true,],
			'admin_id' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
			'answer' => ['type' => 'text','null' => true,],
			'ansFile' => ['type' => 'json', 'null' => true,],
            'ip' => ['type' => 'varchar', 'constraint' => 20, 'null' => true,],
            'regDt' => ['type' => 'datetime','null' => true,],
            'editDt' => ['type' => 'datetime', 'null' => true,],
            'delDt' => ['type' => 'datetime','null' => true,],
        ];
        return $fields;
	}

    public static function co_faq() : array
    {
        $fields = [
            'ano' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true,],
            'sort' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 255,],
            'question' => ['type' => 'varchar', 'constraint' => 255, 'null' => true,],
            'answer' => ['type' => 'text', 'null' => true,],
            'regDt' => ['type' => 'datetime','null' => true,],
            'editDt' => ['type' => 'datetime', 'null' => true,],
            'delDt' => ['type' => 'datetime','null' => true,],
        ];
        return $fields;
    }
}