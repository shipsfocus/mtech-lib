<?php

namespace MtLib\Macros;

use Illuminate\Database\Schema\Blueprint;

class SchemaBlueprintMacros extends Macro
{
    public static $microableClass = Blueprint::class;

    static $microMethods = [
        'nullableString',
        'intTimestamps',
        'nullableForeignId',
    ];

    static function nullableString(Blueprint $bp, string $attr, ?int $length = null)
    {
        $bp->string($attr, $length)->nullable();
    }

    static function intTimestamps(Blueprint $bp)
    {
        $bp->unsignedInteger('updated_at');
        $bp->unsignedInteger('created_at');
    }

    static function nullableForeignId(Blueprint $bp, string $attr, string $foreignTable, string $foreignTableKey = 'id')
    {
        $bp->unsignedInteger($attr)->nullable();

        $bp->foreign($attr)
            ->references($foreignTableKey)
            ->on($foreignTable)
            ->onUpdate('cascade')
            ->onDelete('set null');
    }
}
