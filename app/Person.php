<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Person extends Model
{
    protected $dates = ['scanned_at'];

    public function invite()
    {

    }

    public function join()
    {
        $this->update(['scanned_at' => Carbon::now()]);
    }

    public function getRouteKeyName()
    {
        return 'code';
    }
}
