<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invite extends Model
{
    protected $guarded = ['data'];


    public function encode(array $attributes = [])
    {
        $this->data = json_encode($attributes);
        $this->save();
        return $this;
    }

    public function decode()
    {
        return json_decode($this->data);
    }

    public static function create(array $attributes = [])
    {
        if (!key_exists('code', $attributes))
        {
            $attributes['code'] = static::newCode();
        }

        return static::query()->create($attributes);
    }

    public static function newCode()
    {
        do {
            $tmp = Str::random(20);
        } while (Invite::byCode($tmp));

        return $tmp;
    }

    public static function byCode(string $code)
    {
        return static::where('code', $code)->first();
    }
}
