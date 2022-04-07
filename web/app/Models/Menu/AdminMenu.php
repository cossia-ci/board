<?php
namespace App\Models\Menu;
use App\Models\BaseModel;
class AdminMenu
{
    private $data;
    public function __construct(bool $bool = false)
    {
        $model = new BaseModel('co_admin_menu');
        if( $bool === false ) $model->where('isView', 'y');
        $this->data = $model->orderBy('sort')->findAll();
    }

    public function getTreeData() : array
    {
        $data = [];
        foreach( $this->data as $key => $row ) {
            $data[$key] = $row;
            $data[$key]['type'] = $row['isView']=='n'?'hide':$data[$key]['type'];
            $data[$key]['id'] = $row['ano'];
            $text = $row['controller']??'';
            $text .= $row['class'] ? '::'.$row['class'] :'';
            $data[$key]['text'] = $row['name'].' ['.$row['code'].' | '.$row['folder'].'] '.$text;
        }
        return $this->arrayToTree( $data );
    }
    
    public function getRoutesData( array $data = [] ) : array
    {
        if( $this->data ){
            foreach( $this->data as $row ){
                if( $row['type'] != 'folder' ){
                    $data[] = [
                        'code' => strtolower($row['folder']).'/'.strtolower($row['controller']).'-'.strtolower($row['class']),
                        'controller' => 'Admin\\'.ucfirst($row['folder']).'\\'.ucfirst($row['controller']).'Controller::'.camel_case($row['class']),
                    ];
                }
            }
        }
        return $data;
    }

    public function getLimitlessMenu() : string
    {
        return $this->getMenuData( $this->arrayToTree( $this->data ) );
    }

    public function makeAdminHref( array $row ) : string
    {
        return $row['type'] != 'folder' ? '/admin/'.strtolower($row['folder']).'/'.strtolower($row['controller']).'-'.strtolower($row['class']) : '#.';
    }

    public function makeIcon( array $row ) : string
    {
        return $row['icons'] ? '<i class="'.$row['icons'].'"></i>' : '';
    }

    public function makeActive( array $row, $code = '' ) : string
    {
        return $code != '' && $row['code'] == $code ? ' active' : '';
    }

    public function nameOpen( array $row, $code = '' ) : string
    {
        return $code != '' && $row['code'] == $code ? ' nav-item-expanded nav-item-open' : '';
    }

    public function makeArrow( array $row ) : string
    {
        return $row['type'] == 'folder' ? ' nav-item-submenu' : '';
    }

    public function getMenuData( array $menu = [], int $key = 0 )
    {
        $bnb[] = $key == 0 ? '<ul class="nav nav-sidebar" data-nav-type="accordion">' : '<ul class="nav nav-group-sub">';
        foreach( $menu as $key => $row ){
            if( isset( $row['name']) && $row['name'] ){
                $code = $this->code[ $row['depth'] ]??'';
                $bnb[] = '<li class="nav-item'.$this->nameOpen($row, $code).$this->makeArrow($row).'"><a href="'.$this->makeAdminHref($row).'" class="nav-link'.$this->makeActive($row, $code).'">'.$this->makeIcon($row).'<span>'.$row['name'].'</span></a>';
                if( isset($row['children']) && count($row['children']) )
                    $bnb[] = $this->getMenuData( $row['children'], ($key+1) );
                $bnb[] = '</li>';
            }
        }
        $bnb[] = '</ul>';
        return implode(PHP_EOL, $bnb);
    }

    public function arrayToTree( array $data = [], int $parentId = 0 ) : array
	{
		$branch = [];
		foreach ($data as $key => $element) {
			if ($element['parent'] == $parentId) {
				$children = $this->arrayToTree($data, $element['ano']);
				if ($children) $element['children'] = $children;
                $element['depth'] = $this->getLevel($element['parent']);
				$branch[] = $element;
				unset($data[$key]);
			}
        }
		return $branch;
	}

    public function getLevel( int $parentId = 0 ) : int
    {
        $depth = 0;
        if( $parentId != 0 ){
            foreach( $this->data as $row ){
                if( $row['ano'] == $parentId ) $depth = $this->getLevel( $row['parent'] ) + 1;
            }
        }
        return $depth;
    }

}
