<?php
namespace Config;
use App\Models\Menu\AdminMenu;
$routes = Services::routes();
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) require SYSTEMPATH . 'Config/Routes.php';
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute( false );

# Admin 로그인 안했을때
$routes->group('admin', ['filter' => 'admin-islogOut'], function($routes){
    $routes->get('login', 'Admin\Manager\CertController::logIn');
    $routes->post('post-login', 'Admin\Manager\CertController::PostLogIn');
});

# Admin 로그인 했을때
$routes->group('admin', ['filter' => 'admin-islogin'], function($routes){
	$routes->get('', 'Admin\Main\IndexController::index');
    $routes->get('logout', 'Admin\Manager\CertController::logOut');
    $routes->get('myinfo', 'Admin\Manager\CertController::myInfo');
    
    
    $routes->group('menu', function($routes){
        $routes->get('', 'Admin\Menu\MenuController::index');
        $routes->get('admin', 'Admin\Menu\AdminMenuController::index');
    });
    $menu = new AdminMenu( true );
    foreach( $menu->getRoutesData() as $row )
        $routes->get($row['code'], $row['controller']);
});

# Front 로그인 관련 없음
$routes->group('/', function($routes){
    $routes->get('', 'Front\Main\IndexController::index');

    $routes->get('bdlist/(:alpha)', 'Front\Board\BoardController::list/$1');
	$routes->get('bdread/(:alpha)/(:num)', 'Front\Board\BoardController::read/$1/$2');
	$routes->get('bdwrite/(:alpha)', 'Front\Board\BoardController::write/$1');
	$routes->get('bdedit/(:alpha)/(:num)', 'Front\Board\BoardController::edit/$1/$2');
	$routes->get('bdreplay/(:alpha)/(:num)', 'Front\Board\BoardController::replay/$1/$2');

	$routes->get('html/(:any)', 'Front\Html\HtmlController::html/$1');
	$routes->get('info/(:any)', 'Front\Info\InfoController::info/$1');
	$routes->get('sps/(:any)', 'Front\Special\SpecialController::info/$1');
	$routes->get('spswrite/(:any)', 'Front\Special\SpecialController::write/$1');
});

# Front 로그인 안했을때
$routes->group('/', ['filter' => 'user-islogOut'], function($routes){
	$routes->get('log-in', 'Front\Member\CertController::logIn');
	$routes->get('join-us', 'Front\Member\CertController::JoinUs');
    $routes->get('join-end', 'Front\Member\CertController::JoinEnd');
	$routes->post('post-join', 'Front\Member\CertController::postJoin');
	$routes->post('post-login', 'Front\Member\CertController::postLogin');
    $routes->post('post-find', 'Front\Member\CertController::postFind');
	$routes->get('find-id', 'Front\Member\CertController::findId');
    $routes->get('finded-id', 'Front\Member\CertController::findedId');
	$routes->get('find-pw', 'Front\Member\CertController::findPw');
    $routes->get('finded-pw', 'Front\Member\CertController::findedPw');
});

# Front 로그인 했을때
$routes->group('', ['filter' => 'user-islogin'], function($routes){
    $routes->group('mypage', function($routes){
        $routes->get('', 'Front\Mypage\IndexController::index');
        $routes->get('qna-list', 'Front\Mypage\QnaController::list');
        $routes->get('qna-write', 'Front\Mypage\QnaController::write');
        $routes->get('qna-read/(:num)', 'Front\Mypage\QnaController::read/$1');
        $routes->get('my-info', 'Front\Mypage\MyInfoController::index');
    });
    $routes->get('logout', 'Front\Member\CertController::logOut');
});

# Requst [**로그인 무관**]
$routes->post('requst-post-normal', 'Requst\PostController::index');
$routes->post('requst-post-board-normal', 'Requst\BoardController::index');
$routes->post('requst-post-board-regist', 'Requst\BoardController::regist');
$routes->post('requst-post-cmt', 'Requst\BoardController::comment');
$routes->post('requst-board-delete', 'Requst\BoardController::delete');

$routes->post('admin-menu-post', 'Requst\AjaxController::adminMenu');
$routes->post('editor-upload', 'Requst\AjaxController::editorUpload');
$routes->post('del-ajax-basic', 'Requst\AjaxController::delete');
$routes->post('del-ajax-board', 'Requst\AjaxController::deleteBoard');
$routes->post('del-ajax-content', 'Requst\AjaxController::deleteContent');
$routes->post('bdpw-validat', 'Requst\AjaxController::bdpwValidat');

$routes->post('overlap-custom', 'Requst\AjaxController::overlapCustom');
$routes->post('overlap-front-menu', 'Requst\AjaxController::overlapFmenu');

$routes->get('file-down', '\App\Models\FileModel::fileDownLoad');


if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';