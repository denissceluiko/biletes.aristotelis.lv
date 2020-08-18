<?php

namespace App;

use App\Notifications\DiscountIssued;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class Discount extends Model
{
    protected $fillable = ['code', 'email', 'issued_at', 'sent_at'];
    protected $dates = ['issued_at', 'sent_at'];

    public static $permittedRecievers = [
        'students.lu.lv',
        'edu.lu.lv',
        'lu.lv',
    ];

    public static function make() : Discount
    {
        return Discount::create(['code' => Str::random(10)]);
    }

    public function scopeCode(Builder $query, $code)
    {
        return $query->where('code', $code);
    }

    public function scopeEmail(Builder $query, $email)
    {
        return $query->where('email', $email);
    }

    public function scopeFree(Builder $query)
    {
        return $query->whereNull('email');
    }

    public static function canRecieve($email)
    {
        list($prefix, $suffix) = explode('@', $email);
        return in_array($suffix, self::$permittedRecievers);
    }

    public static function cleanEmail($email)
    {
        list($prefix, $suffix) = explode('@', $email);
        return $prefix;
    }

    public static function findByEmail($email)
    {
        return self::email(self::cleanEmail($email))->first() ?? null;
    }

    public static function issue($email) : Discount
    {
        $discount = self::findByEmail($email);
        if ($discount) return $discount;

        $discount = Discount::free()->first();
        $discount->update(['email' => self::cleanEmail($email), 'issued_at' => Carbon::now()]);
        return $discount;
    }

    public function send($email)
    {
        if ($this->sent_at && $this->sent_at->diffInHours(Carbon::now()) < 3) return;

        $this->mail($email);
        $this->update(['sent_at' => Carbon::now()]);
    }

    public function mail($email)
    {
        Notification::route('mail', $email)
            ->notify(new DiscountIssued($this));
    }

    public static function getGenerated()
    {
        return self::all()->count();
    }

    public static function getSent()
    {
        return self::whereNotNull('sent_at')->count();
    }
}
