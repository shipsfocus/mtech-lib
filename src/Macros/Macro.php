<?php

namespace MtLib\Macros;

abstract class Macro
{
    static $microableClass;

    static $microMethods;

    static function register()
    {
        foreach (static::$microMethods as $method)
        {
            static::registerMacro($method);
        }
    }

    static function registerMacro($methodName)
    {
        $method = static::class . '::' . $methodName;

        (static::$microableClass)::macro($methodName, fn(...$args) => call_user_func_array($method, [$this, ...$args]));
    }
}
