<?php

namespace MtLib;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Http\Request;

class Model extends EloquentModel
{
	protected $dateFormat = 'U';

	protected $hidden = ['created_at', 'updated_at'];

	static function clearGlobalScopes()
	{
		unset(static::$globalScopes[static::class]);
	}

	static function removeGlobalScope($scope)
	{
        unset(static::$globalScopes[static::class][$scope]);
	}

	static function toQueryBuilder(?Request $request = null): QueryBuilder
	{
		return QueryBuilder::for(static::class, $request);
	}

	static function random()
	{
		return static::inRandomOrder()->first();
	}

    function setIfBlank($attr, $value)
    {
        if (blank($this->{$attr})) {
            $this->{$attr} = $value;
        }
    }
}
