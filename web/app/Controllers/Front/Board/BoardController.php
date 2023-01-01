<?php
namespace App\Controllers\Front\Board;
use App\Models\BaseModel;
use App\Models\BoardConfig;
use App\Models\BoardModel;
class BoardController extends \App\Controllers\Front\Controller
{
	public function list( $code )
	{
        $cfg_ = new BoardConfig( $code );
		$cfg = $cfg_->getListSet();
		if( $cfg['type'] == 'write') return redirect()->to("/bdwrite/{$code}");
		if( !$cfg['auth']['bool'] ) return $this->redirectTo( $cfg['auth'] );
		$this->setBody([ 'board', 'list' ]);
		$model = new BoardModel( $code );
		$data = $model->setWhere( $_GET )->setLimt( $cfg['perPage'] )->getList();
		$this->setData('cfg', $cfg);
		$this->setData('notice', $this->getNotice( $code ) );
		$this->setData('data', $data['data']);
		$this->setData('page', $data['page']);
		$this->setData('no', $data['no']);
	}

	public function getNotice( $code ) : array
	{
		$cfg_ = new BoardConfig( $code );
		$cfg = $cfg_->getListSet();
		$data = [];
		if( ( $cfg['noticeView'] == 'f' && $_GET['page'] == 1 ) || $cfg['noticeView'] != 'f' ){
			$model = new BoardModel( $code );
			$data = $model->where('is_notice', 'y')->orderBy('ano','DESC')->findAll($cfg['notice'])??[];
		}
		return $data;
	}
	
	public function edit( $code, $ano )
	{
		$cfg_ = new BoardConfig( $code );
		$cfg = $cfg_->getWriteSet();
		$model = new BoardModel( $code );
		$data = $model->find( $ano );
		if( $data['user_id'] != session('member.ano') ){
			if( !is_admin() )
				return $this->errorTo();
		}
		$cfg['parent'] = $data['parent'];
		$this->setBody([ 'board', 'write' ]);
		$this->setData('cfg', $cfg);
		$this->setData('data', $data);
		$this->setData('backUrl', $this->setBackToList( $code ));
	}

	public function replay( $code, $ano )
	{
		$cfg_ = new BoardConfig( $code );
		$cfg = $cfg_->getReplaySet();
		if( !$cfg['auth']['bool'] ) return $this->redirectTo( $cfg['auth'] );
		$cfg['parent'] = $ano;
		$this->setBody([ 'board', 'write' ]);
		$this->setData('cfg', $cfg);
		$this->setData('backUrl', $this->setBackToList( $code ));
	}

	public function write( $code )
	{
		$cfg_ = new BoardConfig( $code );
		$cfg = $cfg_->getWriteSet();
		if( !$cfg['auth']['bool'] ) return $this->redirectTo( $cfg['auth'] );
		$skin  = $cfg['type'] == 'write' ? 'write-only' : 'write';
		$this->setBody([ 'board', $skin ]);
		$this->setData('cfg', $cfg);
		$this->setData('backUrl', $this->setBackToList( $code ));
	}

	public function read( $code, $ano )
	{
		$cfg_ = new BoardConfig( $code );
		$cfg = $cfg_->getReadSet();
		if( !$cfg['auth']['bool'] ) return $this->redirectTo( $cfg['auth'] );
		
		$model = new BoardModel( $code );
		$data = $model->find( $ano );
		if( !$data ) return $this->errorTo();
		if( $data['pw'] && !session( $code.$ano ) ) return $this->errorTo();

		$this->setBody([ 'board', 'read' ]);
		if( !in_array($ano, session( 'board.'.$code )??[] ) ){
			$sdt['board'][$code][] = $ano;
			session()->set($sdt);
			$model->set('hit', 'hit+1', false)->where('ano', $ano)->update();
		}
		
		if( $data['user_id'] == session('member.ano') ) $cfg['btn']['delete'] = $cfg['btn']['edit'] = true;
		$model = new BoardModel( $code, 'comment' );
		$this->setData('cfg', $cfg);
		$this->setData('data', $data);
		$this->setData('cmt', $model->where('bdano', $ano)->orderBy('ano', 'ASC')->findAll() );
		$this->setData('backUrl', $this->setBackToList( $code ));
	}

	public function errorTo()
	{
		return redirect()->back()->with( 'error', '정상적인 방법이 아닙니다.' );
	}

	public function redirectTo( array $param )
	{
		return redirect()
				->to( $param['url'] )
				->with( 'error', $param['msg'] )
				->with( 'return_url', $param['return_url'] );
	}

	public function setBackToList( $code ) : string
	{
		$parm = get_url_param();
		return '/bdlist/'.$code .= $parm?'?'.$parm:'';
	}
}