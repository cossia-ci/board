<?php
namespace App\Controllers\Front\Html;
use App\Models\BaseModel;
class HtmlController extends \App\Controllers\Front\Controller
{
	public function html( $page )
	{
		$this->setBody([ 'html', $page ]);
	}
}