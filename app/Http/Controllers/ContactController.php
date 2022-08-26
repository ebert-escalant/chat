<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Rules\ContactRule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function index()
    {
        $contacts=auth()->user()->contacts()->paginate();

        return view('contacts.index',compact('contacts'));
    }
    public function create()
    {
        return view('contacts.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>[
                'required',
                'email',
                'exists:users',
                Rule::notIn([auth()->user()->email]),
                new ContactRule
            ]
        ]);
        $user=User::where('email',$request->email)->first();
        $contact=Contact::create([
            'name'=>$request->name,
            'user_id'=>auth()->user()->id,
            'contact_id'=>$user->id
        ]);
        session()->flash('flash.banner','contacto creado correctamente');
        session()->flash('flash.bannerStyle','success');
        return redirect()->route('contacts.index');
    }

    public function edit(Contact $contact)
    {
        return view('contacts.edit',compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name'=>'required',
            'email'=>[
                'required',
                'email',
                'exists:users',
                Rule::notIn([auth()->user()->email]),
                new ContactRule($contact->user->email)
            ]
        ]);
        $user=User::where('email',$request->email)->first();
        $contact->update([
            'name'=>$request->name,
            'contact_id'=>$user->id
        ]);
        session()->flash('flash.banner','contacto actualizado correctamente');
        session()->flash('flash.bannerStyle','success');
        return redirect()->route('contacts.index');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        session()->flash('flash.banner','contacto eliminado correctamente');
        session()->flash('flash.bannerStyle','success');
        return redirect()->route('contacts.index');
    }
}
