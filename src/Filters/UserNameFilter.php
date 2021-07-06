<?php

namespace MtLib\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class UserNameFilter implements Filter
{
    public function __invoke(Builder $query, $input, string $property) : Builder
    {
        return $query->whereHas($property, fn(Builder $q) =>
        	$q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$input}%"])
        );
    }
}

