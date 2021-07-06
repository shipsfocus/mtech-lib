<?php

namespace MtLib\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

abstract class BatchResourceCudController extends Controller
{
    function __invoke(Request $request)
    {
        request()->validate([
            'resource' => ['required', Rule::in($this->resources()->keys())],
            'action' => ['required', Rule::in(['create', 'update', 'delete'])],
            'data' => 'array|required|min:1',
        ]);

        $data = request('data');
        $action = request('action');
        $model = $this->resources()[request('resource')];

        if ($action === 'create' || $action === 'update')
            foreach ($data as $rowData)
                $model::updateOrCreate(['id' => $rowData['id'] ?? NULL], $rowData);

        if ($action === 'delete')
            foreach ($data as $rowData)
                optional($model::find($rowData['id']))->delete();
    }

    abstract function resources(): Collection;
}
