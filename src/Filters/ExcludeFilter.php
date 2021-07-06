<?php

namespace MtLib\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ExcludeFilter implements Filter
{
    public function __invoke(Builder $query, $input, string $property) : Builder
    {
        return $query->where($property, '!=', $input);
    }
}

