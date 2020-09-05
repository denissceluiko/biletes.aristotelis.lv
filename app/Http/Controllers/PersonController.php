<?php

namespace App\Http\Controllers;

use App\Invite;
use App\Person;
use App\Rules\InviteIsRedeemable;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function create()
    {
        $invite = [];
        return view('person.create', compact('invite'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required|min:8',
            'invite_id' => ['sometimes', 'exists:invites,id', new InviteIsRedeemable()],
        ]);

        $person = Person::create($request->all());

        if ($request->has('invite_id'))
        {
            $person->process(Invite::find($request->invite_id));
        }

        return redirect()->route('person.show', $person);
    }

    public function show(Person $person)
    {
        return view('person.show', compact('person'));
    }
}
