<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{
	use Nette\StaticClass;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
        $router[] = new Route('<presenter>/<action>/<id>', array(
            'module' => 'Translator',
            'presenter' => 'Translator',
            'action' => 'default',
            'id' => null,
        ));
		return $router;
	}

}
