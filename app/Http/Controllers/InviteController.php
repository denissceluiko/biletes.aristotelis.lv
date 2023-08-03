<?php

namespace App\Http\Controllers;

use App\Models\Invite;

class InviteController extends Controller
{
    public function show(Invite $invite)
    {
        return view('invite.show', compact('invite'));
    }

    public function redeem(Invite $invite)
    {
        $invite = ['id' => $invite->id] + $invite->decode();
        return view('person.create', compact('invite'));
    }
}
