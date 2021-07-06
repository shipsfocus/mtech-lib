<?php

namespace MtLib\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class FolderExist implements Rule
{
    public function passes($attribute, $value)
    {
        return Storage::disk('uploads')->exists($value);
    }

    public function message()
    {
        return 'The folder does not exist.';
    }
}
