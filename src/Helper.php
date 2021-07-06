<?php

namespace MtLib;

use Illuminate\Support\Carbon;

class Helper
{
    static function epoch(int $ts): Carbon
    {
        return Carbon::createFromTimestamp($ts, 'GMT+8');
    }
}