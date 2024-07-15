<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Rules\CanRecieveDiscount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function application()
    {
        return view('discount.application');
    }

    public function apply(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email', new CanRecieveDiscount]
        ]);

        $discount = Discount::issue($request->email);

        if (!$discount) {
            return view('discount.none-available');
        }

        $discount->send($request->email);

        return view('discount.apply', compact('discount'));
    }
}
