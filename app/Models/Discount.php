<?php

namespace App\Models;

use App\Notifications\DiscountIssued;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class Discount extends Model
{
    use HasFactory;
    
    protected $fillable = ['code', 'email', 'issued_at', 'sent_at'];
    protected $casts = [
        'issued_at' => 'datetime', 
        'sent_at' => 'datetime',
    ];

    public static $permittedRecievers = [
        'students.lu.lv',
        'edu.lu.lv',
        'lu.lv',
    ];

    public static function generate(int $count = 1) : bool
    {
        $codes = collect()->times($count, function () {
            return ['code' => Str::random(10)];
        });

        return Discount::insert($codes->toArray());
    }

    public static function formatRecipient($email)
    {
        list($prefix, $suffix) = explode('@', $email);

        return strlen($prefix) == 7 ? $prefix.'@students.lu.lv' : $email;
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

    public static function issue($email) : ?Discount
    {
        $discount = self::findByEmail($email);
        if ($discount) return $discount;

        $discount = Discount::free()->first();

        if (!$discount) {
            return null;
        }
        
        $discount->update(['email' => self::cleanEmail($email), 'issued_at' => Carbon::now()]);
        return $discount;
    }

    public function send($email)
    {
        if ($this->sent_at && $this->sent_at->diffInHours(Carbon::now()) < 3) return;

        $email = self::formatRecipient($email);
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
