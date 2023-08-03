<?php

namespace App\Models;

use App\Traits\HasCode;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasCode;

    protected $fillable = ['name', 'code', 'type', 'redeems'];
    protected $hidden = ['data'];
    protected $dataDecoded = null;


    public function encode(array $attributes = [])
    {
        $this->data = json_encode($attributes);
        $this->save();
        return $this;
    }

    public function decode()
    {
        return isset($this->data) ? json_decode($this->data, true) : [];
    }

    public static function create(array $attributes = [])
    {
        if (!key_exists('code', $attributes))
        {
            $attributes['code'] = static::newCode();
        }

        return static::query()->create($attributes);
    }

    public function people()
    {
        return $this->hasMany(Person::class);
    }

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function param($key)
    {
        if ($this->dataDecoded == null) {
            $this->dataDecoded = $this->decode();
        }

        return $this->dataDecoded[$key] ?? null;
    }

    public function isSaved()
    {
        return $this->exists;
    }

    public function isRedeemable()
    {
        return $this->people()->count() <= $this->redeems;
    }
}
