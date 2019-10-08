<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactForm\Store;

class ContactFormController extends Controller
{
    public function create()
    {
        return view('contact-form.create');
    }

    public function store(Store $request)
    {
        //
    }
}
