<?php

namespace MtLib;

use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    public $data;

    public function __construct($resource, $data = [])
    {
        parent::__construct($resource);

        $this->data = $data;
    }

    function fillables(...$keys)
    {
        $fillables = $this->getFillable();

        collect($fillables)->merge($keys)->each(function($key) use (&$res) {
            $res[$key] = $this->{$key};
        });

        return $res;
    }

    function makeResponse($res)
    {
        return is_array($this->data) ? array_merge($res, $this->data) : $res;
    }
}
