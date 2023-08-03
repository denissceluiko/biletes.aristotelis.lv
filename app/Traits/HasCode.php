<?php


namespace App\Traits;


use Illuminate\Support\Str;

trait HasCode
{

    public static function newCode()
    {
        do {
            $tmp = Str::random(20);
        } while (static::byCode($tmp));

        return $tmp;
    }

    public static function byCode(string $code)
    {
        return static::where('code', $code)->first();
    }
}
