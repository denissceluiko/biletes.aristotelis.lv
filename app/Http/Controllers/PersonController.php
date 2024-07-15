<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use App\Models\Person;
use App\Rules\InviteIsRedeemable;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function create()
    {
        $invite = new Invite;
        return view('person.create', compact('invite'));
    }

    public function store(Request $request)
    {
        return response(status: 404);
        
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
        } else {
            $person->elevate('free');
        }

        return redirect()->route('person.show', $person);
    }

    public function show(Person $person)
    {
        return view('person.show', compact('person'));
    }
}
