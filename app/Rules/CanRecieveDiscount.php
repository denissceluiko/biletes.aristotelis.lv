<?php

namespace App\Rules;

use App\Models\Discount;
use Illuminate\Contracts\Validation\Rule;

class CanRecieveDiscount implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Discount::canRecieve($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Atlaides kodu var saņemt tikai LU e-pasta adrešu īpašnieki: @'.implode(', @', Discount::$permittedRecievers);
    }
}
