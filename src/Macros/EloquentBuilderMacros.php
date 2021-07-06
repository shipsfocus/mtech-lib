<?php

namespace MtLib\Macros;

use Illuminate\Database\Eloquent\Builder;

class EloquentBuilderMacros extends Macro
{
    public static $microableClass = Builder::class;

    static $microMethods = [
        'updateOrCreateWhileIgnoringDuplicates',
    ];

    static function updateOrCreateWhileIgnoringDuplicates(Builder $builder, array $attributes, array $values = [])
    {
        try {
            return $builder->updateOrCreate($attributes, $values);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return $builder->where($attributes)->first();
            }
            else throw $e;
        }
    }
}
