<?php

namespace MtLib\Filters;

use Spatie\QueryBuilder\Filters\{Filter, FiltersPartial};
use Illuminate\Database\Eloquent\Builder;

class RelationalNumberFilter extends FiltersPartial implements Filter
{
    public function __invoke(Builder $query, $values, string $property)
    {
    	if ($this->isRelationProperty($query, $property)) {
            return $this->withRelationConstraint($query, $values, $property);
        }

        return (new NumberFilter)($query, $values, $property);
    }
}

