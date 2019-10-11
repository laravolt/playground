<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactForm\Store;
use Illuminate\Http\Request;

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
