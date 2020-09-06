<?php

namespace App;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Person extends Model
{
    use HasCode;

    public static $levels = [
        'free' => 'white',
        'regular' => 'purple',
        'vip' => 'silver',
        'svip' => 'gold',
        'org' => 'red',
    ];

    protected $guarded = ['level'];
    protected $dates = ['scanned_at'];

    public function arrive()
    {
        $this->update(['arrived_at' => Carbon::now()]);
    }

    public function invite()
    {
        return $this->belongsTo(Invite::class);
    }

    public function elevate($level)
    {
        if (!key_exists($level, static::$levels))
            return $this;
        $this->level = $level;
        $this->save();
        return $this;
    }

    public function process(Invite $invite)
    {
        $data = $invite->decode();
        return $this
            ->elevate($data['level'] ?? null)
            ->update($data);
    }

    public static function create(array $attributes = [])
    {
        $attributes['code'] = $attributes['code'] ?? static::newCode();
        return static::query()->create($attributes);
    }

    public function qrCode()
    {
        $options = new QROptions([
            'version'    => 5,
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'   => QRCode::ECC_M,
        ]);

        $qrcode = new QRCode($options);

        return $qrcode->render($this->code);
    }

    public function getRouteKeyName()
    {
        return 'code';
    }
}
