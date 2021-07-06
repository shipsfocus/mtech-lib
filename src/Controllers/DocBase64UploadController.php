<?php

namespace MtLib\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use MtLib\Rules\FolderExist;

class DocBase64UploadController extends Controller
{
    public function __invoke(Request $request)
    {
        request()->validate([
            'b64' => 'required|string|starts_with:data',
            'folder' => ['required', new FolderExist],
            'file_name' => 'string',
        ]);

        $b64 = request('b64');

        preg_match('/^data:(image|application)\/(.+?);base64,/', $b64, $matches);

        $b64Prefix = $matches[0] ?? NULL;

        $imgExt = $matches[2] ?? '';

        $fileName = request('file_name', Str::random(20).".$imgExt");

        $hashFolder = Str::random(12);

        $filePath = request('folder') . "/$hashFolder/$fileName";

        $b64 = str_replace($b64Prefix, NULL, $b64);

        Storage::disk('uploads')->put($filePath, base64_decode($b64));

        return ['file_path' => $filePath];
    }
}
