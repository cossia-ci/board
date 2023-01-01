<?php
namespace App\Controllers\Admin\Member;
use App\Models\BaseModel;
class MemberController extends \App\Controllers\Admin\Controller
{
    public function list()
    {
        $model = new BaseModel('co_memberLevel');
        $level = $model->orderBy('level ASC')->findAll();
        if( !$level ) return redirect()->to('/admin/member/memlevel-list')->with('error','회원 등급이 없습니다.');
        $join = get_config_data('member','join');
        if( !$join ) return redirect()->to('/admin/member/member-config')->with('error','가입항목을 설정해 주세요.');
        
        helper('text');
        $this->setBody(['member', 'list'],'member/member');
        $this->setNave(['회원관리', '회원목록']);
        $_GET['channel'] = $_GET['channel']??array_keys(get_login_channel());
        $_GET['app'] = $_GET['app']??['y', 'n'];
        $model = new BaseModel('co_member');
        
        if( count($_GET['app']) != 2 ) $model->where('app', $_GET['app'][0]);
        if( count($_GET['channel']) != count(get_login_channel()) )
            $model->whereIn('channel', $_GET['channel']);
        
        $data = $model->setWhere()->orderBy('ano DESC')->getList();
        $this->setData('data', $data['data']);
        $this->setData('page', $data['page']);
    }

    public function config()
    {
        $model = new BaseModel('co_memberLevel');
        $level = $model->orderBy('level ASC')->findAll();
        if( !$level ) return redirect()->to('/admin/member/memlevel-list')->with('error', '회원 등급이 없습니다.');
        $this->setData('level', $level);
        $this->setBody(['member', 'config']);
        $this->setNave(['회원관리', '가입정보']);
        $this->setData('data', get_config_data('member','join'));
    }

    public function regist()
    {
        $model = new BaseModel('co_memberLevel');
        $level = $model->orderBy('level ASC')->findAll();
        if( !$level ) return redirect()->to('/admin/member/memlevel-list')->with('error', '회원 등급이 없습니다.');
        $join = get_config_data('member','join');
        if( !$join ) return redirect()->to('/admin/member/member-config')->with('error','가입항목을 설정해 주세요.');
        $this->setBody(['member', 'regist']);
        $this->setNave(['회원관리', '회원등록']);
        $data = [];
        if( isset($_GET['ano']) && $_GET['ano'] ){
            $model = new BaseModel('co_member');
            $data = $model->find($_GET['ano']);
        }
        $this->setData('disabled', isset($data['socialId']) && $data['socialId'] ? 'disabled' : '' );
        $this->setData('level', $level);
        $this->setData('data', $data);
        $this->setData('join', $join['data']);
    }
}