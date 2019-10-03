<?php

namespace App\Http\Controllers;

use App\Models\ContactForm;
use Illuminate\Support\Facades\DB;

class ContactFormController extends Controller
{
    public function create()
    {
        return view('contact-form.create');
    }

    public function store(\App\Http\Requests\ContactForm\Store $request)
    {
        // 1.a Insert menggunakan query builder (define fields satu per satu)
        // DB::table('contact_forms')->insert([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'message' => $request->message,
        // ]);

        // 1.b Insert menggunakan query builder, memanfaatkan method only atau excep dari FormRequest
        // untuk mem-filter fields apa saja yang ingin disimpan.
        // DB::table('contact_forms')->insert($request->only(['name', 'email', 'message']));
        // DB::table('contact_forms')->insert($request->except(['_token']));

        // 1.c Sebenarnya bisa lebih singkat lagi dengan memanggil $request->all(),
        // tapi akan menyebabkan error. Tahu kenapa?
        // DB::table('contact_forms')->insert($request->all());

        // 1.d Opsi lain adalah memanggil $request->validated(), dimana
        // hanya field yg didefinisikan di FormRequest::rules() yang akan disimpan.
        // WARNING: jika ada field yang tidak perlu divalidasi, tetap harus dituliskan di
        // FormRequest tetapi cukup diset sebagai empty string atau empty array:
        //        return [
        //             'name' => ['required', new MinimumWords(2)],
        //             'email' => ['required', 'email'],
        //             'message' => [],
        //         ];
        // DB::table('contact_forms')->insert($request->validated());

        // 2. Model Instance
        $contactForm = new ContactForm();
        $contactForm->name = $request->name;
        $contactForm->email = $request->email;
        $contactForm->message = $request->message;
        $contactForm->save();
    }
}
