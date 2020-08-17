<?php

namespace App\Http\Controllers;

use App\Discount;
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

        // check @lu.lv

        $discount = Discount::issue($request->email);

        $discount->send($request->email);

        return view('discount.apply', compact('discount'));
    }
}
