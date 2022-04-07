<?php
namespace App\Models\Menu;
use App\Models\BaseModel;
class FrontMenu
{
    private $data;
    public function __construct(bool $bool = false)
    {
        $this->model = new BaseModel('co_front_menu');
        if( $bool === false ) $this->model->where('isView', 'y');
        $this->data = $this->model->orderBy('sort')->findAll();
        $this->getThisNo();
    }

    public function getThisNo( string $type = '', string $link = '' ) : void
    {
        $arr = explode('/', uri_string() );
        $link = $arr[1] ?? '';
        if( isset($arr[0]) && $arr[0] ){
            switch($arr[0]){
                case 'info':        $type = 'i';    break;
                case 'html':        $type = 'h';    break;
                case 'bdlist' : case 'bdread' : case 'bdwrite' : case 'bdedit' : case 'bdreplay' :
                    $type = 'b';
                break;
                case 'sps' : case 'spswrite' :
                    $type = 's';
                break;
            }
        }
        $this->no = $this->model->select('ano')->where(['type'=>$type,'link'=>$link])->first()['ano']??0;
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

    public function getParentArray( int $no = 0, array &$depth = [] ) : array
    {
        if( $no != 0 ){
            foreach( $this->data as $row ){
                if( $row['ano'] == $no ) {
                    $depth[] = $row['name'];
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
        $data = $this->getNowPageArray();
        return is_array($data) ? implode($branch, $data) : '';
    }

    /*
    * 현제 페이지 타이틀을 알려준다
    */
    public function getNowPageTitle() : string
    {
        return $this->model->select('name')->find( $this->no )['name']??'';
    }

    /*
    * 현제 페이지의 서브 메뉴들 ex) [ [ano, ...],[],[], ]
    */
    public function getSubMenuArray( $data = [] ) : array
    {
        if( $this->no != 0 )
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
        // return ( isset($row['children']) && count($row['children']) ) ? 'have-children' : '';
        return ( isset($row['children']) && count($row['children']) ) ? ' dropdown ' : '';
        
    }

    public function makeHref( array $row ) : string
    {
        switch($row['type']){
            case 'f' : $link = '#.'; break;
            case 'i' : $link = '/info/'.$row['link']; break;
            case 'h' : $link = '/html/'.$row['link']; break;
            case 'b' :
                $link = '/bdlist/'.$row['link'];
            break;
            case 's' :
                $link = '/sps/'.$row['link'];
            break;
        }
        return $link;
    }

    public function makeClassActive( array $row, $code = '' ) : string
    {
        return $code != '' && $row['code'] == $code ? ' active' : '';
    }

    public function forBootstrapDropdown( array $row ) : string
    {
        return ( isset($row['children']) && count($row['children']) ) ? 'class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"' : '';
    }
    public function forBootstrapDropdownSpan( array $row ) : string
    {
        return ( isset($row['children']) && count($row['children']) ) ? ' <span class="caret"></span>' : '';
    }

    public function makeGnbMenu( array $menu = [], string $clsNm = '', string $add = '' ) : string
	{
        $bnb[] = '<ul class="'.$clsNm.'" '.$add.' >';
        foreach( $menu as $key => $row ){

            // $bnb[] = '<li class="'.$this->makeHaveChildren( $row ).'"><a href="'.$this->makeHref($row).'" class="'.$this->makeClassActive($row).'"><span>'.$row['name'].'</span></a>';

            $bnb[] = '<li class="'.$this->makeHaveChildren( $row ).$this->makeClassActive($row).'"><a href="'.$this->makeHref($row).'" '.$this->forBootstrapDropdown( $row ).' ><span>'.$row['name'].'</span>'.$this->forBootstrapDropdownSpan( $row ).'</a>';
            if( isset($row['children']) && count($row['children']) ){
                // $bnb[] = '<i class="fas fa-caret-down has-children"></i>';
                // $bnb[] = $this->makeGnbMenu( $row['children'], 'sub-menu' );
                $bnb[] = $this->makeGnbMenu( $row['children'], 'dropdown-menu', 'role="menu"' );
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
}
