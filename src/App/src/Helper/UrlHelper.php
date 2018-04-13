<?php

namespace App\Helper;

use Zend\Expressive\Helper\UrlHelper as ZendUrlHelper;

class UrlHelper extends ZendUrlHelper
{
	public function getRouteResult()
	{
		return parent::getRouteResult();
	}
}