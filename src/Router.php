<?php

namespace MtLib;

use Illuminate\Routing\Router as BaseRouter;
use Illuminate\Support\Str;

class Router extends BaseRouter
{
	public function apiControllers($baseRoute, $options = [])
	{
        $actions = $options['only'] ?? ['index', 'show', 'store', 'update', 'destroy'];

        if (isset($options['except'])) {
            $actions = array_diff($actions, (array) $options['except']);
        }

        $model = Str::singular( Str::camel($baseRoute) );
        $controllerNS = $options['namespace'] ?? ucfirst($model);

		if (in_array('index', $actions))
			$this->get("$baseRoute", "$controllerNS\IndexController");

		if (in_array('show', $actions))
			$this->get("$baseRoute/{{$model}}", "$controllerNS\ShowController");

		if (in_array('store', $actions))
			$this->post("$baseRoute", "$controllerNS\StoreController");

		if (in_array('update', $actions))
			$this->put("$baseRoute/{{$model}}", "$controllerNS\UpdateController");

		if (in_array('destroy', $actions))
			$this->delete("$baseRoute/{{$model}}", "$controllerNS\DestroyController");
	}
}