<?php

namespace MtLib\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use MtLib\Rules\FolderExist;

class DocBinaryUploadController extends Controller
{
    public function __invoke(Request $request)
    {
        request()->validate([
        	'file' => 'required|file',
        	'folder' => ['required', new FolderExist],
            'file_name' => 'string',
        ]);

        $uploadedFile = request()->file('file');

        $storedPath = request('folder') . '/' . Str::random(12);

        $fileName = request('file_name', $uploadedFile->getClientOriginalName());

        return [
            'file_path' => $uploadedFile->storeAs($storedPath, $fileName, 'uploads')
        ];
    }
}
