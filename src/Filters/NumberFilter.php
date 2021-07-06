<?php

namespace MtLib\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class NumberFilter implements Filter
{
    protected $query;
    protected $property;
    protected $operator;
    protected $value1;
    protected $value2;

    public function __invoke(Builder $query, $values, string $property) : Builder
    {
        $this->query = $query;
        $this->property = $property;
        $this->operator = $values[0] ?? null;
        $this->value1 = $values[1] ?? null;
        $this->value2 = $values[2] ?? null;

        abort_if(
            is_string($values) || blank($this->operator) || blank($this->value1),
            422, "Filter parameters for $property is incorrect."
        );

        return $this->buildQuery();
    }

    private function buildQuery() : Builder
    {
        switch ($this->operator)
        {
            case 'is':
                $queryMethod = 'where' . Str::studly($this->value1);
                return in_array($queryMethod, ['whereNull', 'whereNotNull']) ?
                    $this->query->{$queryMethod}($this->property) : $this->query;

            case 'between':
                return $this->query->whereBetween($this->property, [$this->value1, $this->value2]);

            default:
                return $this->query->whereRaw(
                    sprintf('%s %s ?', $this->property, $this->opTranslate($this->operator)),
                    $this->value1
                );
        }
    }

    private function opTranslate($strOperator)
    {
        switch ($strOperator) {
            case 'gt': return '>';
            case 'gte': return '>=';
            case 'lt': return '<';
            case 'lte': return '<=';
            case 'eq': return '=';
            case 'like': return 'LIKE';
            case 'between': return 'BETWEEN';
            default: return $strOperator;
        }
    }
}

