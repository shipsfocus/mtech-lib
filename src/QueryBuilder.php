<?php

namespace MtLib;

use Exception;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder as BaseQueryBuilder;

class QueryBuilder extends BaseQueryBuilder
{
    protected $dateFormat = 'U';
    public $total;
    public $page;
    public $limit;

    function setPagination($options = [])
    {
        $this->setLimit(request('limit', $options['default_limit'] ?? 10));
        $this->setPage(request('page', 1));
        $offset = ($this->page - 1) * $this->limit;
        $this->limit($this->limit)->offset($offset);
        return $this;
    }

    function getPaginationMeta(): array
    {
        $total = $this->total ?? $this->offset(0)->count();

        throw_unless($this->limit, new Exception('Did you forget to setPagination()?'));

        return [
            'total' => $total,
            'per_page' => $this->limit,
            'current_page' => $this->page,
            'last_page' => intval(ceil($total / $this->limit))
        ];
    }

    function getUniqueList(...$columns): array
    {
        $res = [];

        $excludeFilterName = $this->request->get('list_exclude_self_filter');

        foreach ($columns as $column)
        {
            $query = clone $this->getQuery();

            $matched = collect($this->getProtected('allowedFilters') ?? [])
                ->first(fn($filter) => $filter->getName() === $column);

            $sqlColName = optional($matched)->getInternalName() ?? $column;

            if ($excludeFilterName === $column)
            {
                $query->wheres = collect($query->wheres)
                    ->reject(fn($where) => ($where['column'] ?? '__NIL__') === $sqlColName)
                    ->reject(fn($where) => Str::contains($where['sql'] ?? '__NIL__', "`{$sqlColName}`"))
                    ->toArray();
            }

            $res[$column] = $query
                ->offset(0)
                ->limit(PHP_INT_MAX)
                ->distinct()
                ->pluck($sqlColName)
                ->toArray();
        }

        return $res;
    }

    function setLimit($limit)
    {
        $limit = intval($limit);

        $this->limit = $limit > 0 ? $limit : 1;

        return $this;
    }

    function setPage($page)
    {
        $page = intval($page);

        $this->page = $page > 0 ? $page : 1;
    }
}
