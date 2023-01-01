<?php
namespace App\Models\Menu;
use App\Models\BaseModel;
class FrontMenu
{
    private $data;
    private $infoPage = ['privacy', 'tos', 'email'];
    private $pageNm = '';
    private $nowUrl = [];
    private $ignorePage = [
        'info' => [
            'privacy' => '개인정보 취급방침',
            'tos' => '이용약관',
            'email' => '이메일무단수집거부',
        ],
        'mypage' => [
            'my-info' => '마이페이지',
            'qna-list' => '마이페이지',
            'qna-write' => '마이페이지',
            'qna-read' => '마이페이지',
        ],
        'log-in' => '로그인',
        'join-us' => '회원가입',
    ];
    private $ignorePageNm = [
        'info' => [
            'privacy' => '개인정보 취급방침',
            'tos' => '이용약관',
            'email' => '이메일무단수집거부',
        ],
        'mypage' => [
            'my-info' => '나의정보',
            'qna-list' => '1:1문의',
        ],
    ];

    # 형제메뉴들 불러오기
    public function getSibling( int $ano = 99999999 ) : array
    {
        $return = [];
        # 조상 번호가 아닐때
        if( $ano == 99999999 ){
            if( $this->checkIgnorePage() ){  # 예외 페이지 일때
                if( isset( $this->nowUrl[1] ) && $this->nowUrl[1] ){
                    foreach( $this->ignorePageNm[ $this->nowUrl[0] ] as $key => $row )
                        $return[] = [ 'href' => '/'.$this->nowUrl[0].'/'.$key, 'name' => $row, 'class' => $key==$this->nowUrl[1]?true:false ];
                } 
            }else{  # 일반페이지 일때
                $parent = $this->getParentNo();
                if( $parent != 0 ){
                    $data = $this->model->where(['parent'=>$parent,'isView'=>'y'])->findAll();
                    foreach( $data as $row )
                        $return[] = [  'href' => $this->makeHref($row), 'name' => $row['name'], 'class' => $row['ano']==$this->no?true:false ];
                }
            }
        }
        # 조상 번호를 넣었을때?
        else {

        }
        return $return;
    }

    public function getFirstCategory()
    {
        $data = $this->model->where(['parent' => 0, 'isView' => 'y'])->orderBy('sort ASC')->findAll();
        $data_ = [];
        foreach( $data as $row ){
            $data_[] = [ 'href' => $this->makeHref( $row ), 'name' => $row['name'] ];
        }
        return $data_;
    }

    
    

    # link page 만들어주기
    public function makeHref( array $row ) : string
    {
        return match( $row['type'] ){
            'f'     => $row['link']??'#.',
            'i'     => '/info/'.$row['link'],
            'h'     => '/html/'.$row['link'],
            'b'     => '/bdlist/'.$row['link'],
            'd'     => '/'.strtolower($row['folder'])
                        .'/'.strtolower($row['controller'])
                        .'/'.strtolower($row['class']),
            's'     => '/sps/'.$row['link'],
        };
    }

    # 예외 페이지에 있는지 확인
    public function checkIgnorePage() : bool
    {
        return in_array( $this->nowUrl[0], array_keys( $this->ignorePage ) );
    }

    # 예외 페이지에 이름 불러오기
    public function getIgnorePageNm( string $dotNm = '', int $i = 1 ) : string
    {
        helper('array');
        if( isset( $this->nowUrl[$i] ) ) return $this->getIgnorePageNm( $dotNm.'.'.$this->nowUrl[$i], $i+1 );
        return dot_array_search( $dotNm, $this->ignorePage );
    }

    # css 서브메뉴얼 class 불러오기
    public function getClassFinalNm() : int | string
    {
        return match( $this->checkIgnorePage() ){
            true => $this->nowUrl[0],
            default => $this->no ? $this->getFinalParentNo( $this->no ) : 0
        };
    }

    # 서브메뉴얼 제목 불러오기
    public function getSubVisualNm() : string
    {
        return match( $this->checkIgnorePage() ){
            true => $this->getIgnorePageNm( $this->nowUrl[0] ),
            default => $this->getNomalPageNm()
        };
    }

    # 내부에서 사용 일반페이지 이름 불러오기
    public function getNomalPageNm() : string
    {
        if( !isset( $this->no ) ) $this->getThisNo();
        if( $this->nowUrl[0] ) $name = $this->nowUrl[0];
        return $this->getAnoName( $this->getFinalParentNo( $this->no ) );
    }

    # 내부에서 사용? 최고 조상의 ano 불러오기
    public function getFinalParentNo( $ano ) : int
    {
        $data = $this->model->find( $ano );
        if( $data['parent'] != 0 ) return $this->getFinalParentNo( $data['parent'] );
        return $data['ano'];
    }

    # ano 의 이름 불러오기
    public function getAnoName( $ano ) : string
    {
        return $this->model->select('name')->find( $ano )['name'];
    }

    public function __construct(bool $bool = false)
    {
        $this->nowUrl = explode( '/', uri_string(true) );
        $this->model = new BaseModel('co_frontMenu');
        if( $bool === false ) $this->model->where('isView', 'y');
        $this->data = $this->model->orderBy('sort')->findAll();
        $this->getThisNo();
    }

























    public function matchInfo( string $str = '' ) : string
    {
        if( in_array($str, $this->infoPage) ){
            $this->pageNm = match( $str ){
                'privacy'   => '개인정보 취급방침',
                'tos'       => '이용약관',
                'email'     => '이메일무단수집거부',
                default     => ''
            };
        }
        return 'i';
    }
	
	public function getDevelopAno( array $link ) : int
	{
		$this->model->select('ano')->where(['type'=>'d','folder'=>$link[0]]);
		if( isset($link[1]) && $link[1] ) $this->model->where('controller', $link[1]);
		if( isset($link[2]) && $link[2] ) $this->model->where('class', $link[2]);
		return $this->model->first()['ano']??0;
	}

    public function getThisNo( string $type = '', string $link = '' ) : void
    {
        $arr = explode('/', uri_string() );
        $link = $arr[1] ?? '';
        if( isset($arr[0]) && $arr[0] ){
            $type = match( $arr[0] ){
                'info'                                                  => $this->matchInfo( $link ),
                'html'                                                  => 'h',
                'bdlist', 'bdread', 'bdwrite', 'bdedit', 'bdreplay'     => 'b',
                'sps', 'spswrite'                                       => 's',
                default                                                 => 'd'
            };
        }
        $this->no = match( $type ){
            'd'     => $this->getDevelopAno( $arr ),
            default => $this->model->select('ano')->where(['type'=>$type,'link'=>$link])->first()['ano']??0
        };
    }

    /*
    * 현제 페이지를 배열로 넘겨준다 ex) [게시판, 자유게시판]
    */
    public function getNowPageArray( $data = [] ) : array
    {
        if( isset($this->code) ){
            foreach( $this->code as $row ){
                foreach( $this->data as $row_ ) if( $row == $row_['code'] ) $data[] = $row_['name'];
            }
        }
        if( $this->no != 0 ){
            $data = array_reverse( $this->getParentArray( $this->no ) );
        }
        return $data;
    }

    public function getParentSort( bool $bool = false ) : string|int
    {
        $data = array_reverse( $this->getParentArray( $this->no ) );
        return match( $bool ){
            true => $data[0]['name']??'',
            false => $data[0]['ano']??0
        };
    }

    public function getParentArray( int $no = 0, array &$depth = [] ) : array
    {
        if( $no != 0 ){
            foreach( $this->data as $row ){
                if( $row['ano'] == $no ) {
                    $depth[] = ['name' => $row['name'], 'ano' => $row['ano']];
                    $this->getParentArray( $row['parent'], $depth );
                }
            }
        }
        return $depth;
    }

    /*
    * 현제 페이지를 알려준다 ex) 게시판 > 자유게시판
    */
    public function getNowPageString( string $branch = ' > ' ) : string
    {
        $data = $this->getArrayNames( $this->getNowPageArray() );
        return is_array($data) ? implode($branch, $data) : '';
    }

    # 현제 페이지 array 방식이 바뀜에 따라 다시 한번 가공
    public function getArrayNames( array $arr ) : array
    {
        $data = [];
        foreach( $arr as $row ) $data[] = $row['name'];
        return $data;
    }

    /*
    * 현제 페이지 타이틀을 알려준다
    */
    public function getNowPageTitle() : string
    {
        return $this->model->select('name')->find( $this->no )['name']??$this->pageNm;
    }

    /*
    * 현제 페이지의 서브 메뉴들 ex) [ [ano, ...],[],[], ]
    */
    public function getSubMenuArray( $data = [] ) : array
    {
		if( $this->no != 0 && $this->getParentNo() != 0 )
            $data = $this->model->where(['isView'=>'y', 'parent'=>$this->getParentNo(), 'type != '=>'f'])
                            ->orderBy('`parent` ASC, `sort` ASC')->findAll();
        return $data;
    }

    /*
    * 현제 페이지의 서브 메뉴들 ex) <ul ><li></li></ul>
    */
    public function getSubMenuString( string $clsNm = 'little-menu' ) : string
    {
        return $this->makeGnbMenu( $this->getSubMenuArray(), $clsNm );
    }

    # 바로위 조상번호 불러오기
    public function getParentNo( $parentNo = 0 ) : int
    {
        if( $this->no != 0 )
            foreach( $this->data as $row )
                if( $row['ano'] == $this->no ) $parentNo = $row['parent'];
        return $parentNo;
    }

    public function getGnbMenu( string $class = 'gnb' ) : string
    {
        return $this->makeGnbMenu( $this->getTreeData(), $class );
    }

    public function makeHaveChildren( $row ) : string
    {
        return ( isset($row['children']) && count($row['children']) ) ? 'have-children' : '';
    }

    public function makeClassActive( array $row, $code = '' ) : string
    {
        return $code != '' && $row['code'] == $code ? ' active' : '';
    }

    public function forBootstrapDropdown( array $row ) : string
    {
        //return ( isset($row['children']) && count($row['children']) ) ? 'class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"' : '';
        return '';
    }
    public function forBootstrapDropdownSpan( array $row ) : string
    {
        // return ( isset($row['children']) && count($row['children']) ) ? ' <span class="caret"></span>' : '';
        return '';
    }

    public function makeGnbMenu( array $menu = [], string $clsNm = '', string $add = '' ) : string
	{
        $bnb[] = '<ul class="'.$clsNm.'" '.$add.' >';
        foreach( $menu as $key => $row ){
            $bnb[] = '<li class="'.$this->makeHaveChildren( $row ).$this->makeClassActive( $row ).'"><a href="'.$this->makeHref($row).'" '.$this->forBootstrapDropdown( $row ).' ><span>'.$row['name'].'</span>'.$this->forBootstrapDropdownSpan( $row ).'</a>';
            if( isset($row['children']) && count($row['children']) ){
                $bnb[] = $this->makeGnbMenu( $row['children'], '' );
            }
            $bnb[] = '</li>';
        }
        $bnb[] = '</ul>';
        return implode(PHP_EOL, $bnb);
	}

    public function getTreeData() : array
    {
        $data = [];
        foreach( $this->data as $key => $row ) {
            $data[$key] = $row;
            $data[$key]['type'] = $row['isView']=='n'?'hide':$data[$key]['type'];
            $data[$key]['id'] = $row['ano'];
            $link = $row['link'] ? ' ['.$row['link'].'] ' : '';
            $data[$key]['text'] = $row['name'].$link;
        }
        return $this->arrayToTree( $data );
    }

    public function arrayToTree( array $data = [], int $parentId = 0 ) : array
	{
		$branch = [];
		foreach ($data as $key => $element) {
			if ($element['parent'] == $parentId) {
				$children = $this->arrayToTree($data, $element['ano']);
				if ($children) $element['children'] = $children;
				$branch[] = $element;
				unset($data[$key]);
			}
        }
		return $branch;
	}

	public function getSiblingChild( int $parent = 0, string $class = '' ) : string
    {
        $data = $this->model->where(['parent'=>$parent,'isView'=>'y'])->orderBy('sort ASC')->findAll();
        $bnb[] = '<ul class="'.$class.'" >';
        foreach( $data as $row ){
            $bnb[] = '<li class="'.$this->makeHaveChildren( $row ).$this->makeClassActive( $row ).'"><a href="'.$this->makeHref($row).'"><span>'.$row['name'].'</span></a></li>';
        }
        $bnb[] = '</ul>';
        return implode(PHP_EOL, $bnb);
    }
}
