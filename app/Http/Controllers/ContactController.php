<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(ContactRequest $request)
    {
        $validated = $request->validated();

        $post = Contact::create($validated);

        return view('confirm', compact('post'));
    }

    public function thanks()
    {
        return view('thanks');
    }
}
