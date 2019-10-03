# Contact Form



# Misi 1: Form & Validasi

## 1. Mendefinisikan Route

```php
Route::get('contact-form', 'ContactFormController@create')->name('contact-form.create');
Route::post('contact-form', 'ContactFormController@store')->name('contact-form.store');
```



## 2. Membuat Controller

### 2.1. Jalankan Generator

Jalankan perintah `php artisan make:controller ContactFormController`

### 2.2. Tambahkan Method `create` dan `store`

```php
public function create()
{
    return view('contact-form.create');
}

public function store(Request $request)
{
    //
}
```



## 3. Tambahkan View

Membuat skeleton view di `resources/views/contact-form/create.blade.php`.

```php+HTML
@extends('ui::layouts.centered')
@section('content')

@stop
```



## 4. Membuat Form

Memanfaatkan semantic-form untuk memudahkan pembuatan form HTML.

```php+HTML
@extends('ui::layouts.centered')
@section('content')
    <h1 class="ui header dividing m-b-2">Apa yang bisa kami bantu?</h1>
    {!! form()->post(route('contact-form.create')) !!}
    {!! form()->text('name')->label('Nama Lengkap') !!}
    {!! form()->email('email')->label('Alamat Email') !!}
    {!! form()->textarea('message')->label('Pesan') !!}
    {!! form()->submit('Kirim') !!}
    {!! form()->close() !!}
@stop
```



## 5. Validasi Form



### 5.1. Generate `FormRequest`

Jalankan perintah `php artisan make:request ContactForm/Store`



### 5.2. Modifikasi `rules()` dan `authorize()` 

```php
<?php

namespace App\Http\Requests\ContactForm;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required'],
            'message' => ['required'],
        ];
    }
}

```



### 5.3. Pasangkan ke `ContactFormController@store`

```php
public function store(\App\Http\Requests\ContactForm\Store $request)
{
    //
}
```



### 5.4. Membuat Custom Validation Rule

Jalankan perintah `php artisan make:rule MinimumWords`



### 5.5. Implementasi Rule

```php
<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinimumWords implements Rule
{
    /**
     * @var int
     */
    protected $limit;

    /**
     * Create a new rule instance.
     *
     * @param mixed $limit
     */
    public function __construct($limit = 3)
    {
        $this->limit = $limit;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return str_word_count($value) >= $this->limit;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ":attribute harus mengandung {$this->limit} suku kata atau lebih";
    }
}
```



### 5.6. Daftarkan Custom Rule Ke FormRequest

```php
public function rules()
{
    return [
        'name' => ['required', new \App\Rules\MinimumWords(2)],
        'email' => ['required', 'email'],
        'message' => ['required', 'min:20'],
    ];
}
```



# Misi 2: Menyimpan ke Database

## Membuat Model

`php artisan make:model Models/ContactForm`

## Membuat Migration Script

`php artisan make:migration create_contact_forms_table`



> Model dan migration script bisa digenerate sekaligus dengan flag `-m`:
>
> `php artisan make:model Models/ContactForm -m`

### Menyimpan via Query Builder

```php
use Illuminate\Support\Facades\DB;

// Define kolom satu per satu, bayangkan kalau kolomnya ada belasan atau puluhan 🤦
DB::table('contact_forms')->insert([
     'name' => $request->name,
     'email' => $request->email,
     'message' => $request->message,
]);

// Cara lebih ringkas
DB::table('contact_forms')->insert($request->only(['name', 'email', 'message']));
DB::table('contact_forms')->insert($request->except(['_token']));
DB::table('contact_forms')->insert($request->validated()); //⭐
```



### Menyimpan via Model Instance

```php
use App\Models\ContactForm;

// Cara paling lumrah dan paling OOP, tapi kasusnya sama seperti di atas, kita harus mendefinisikan mapping kolom satu per satu.
$contactForm = new ContactForm();
$contactForm->name = $request->name;
$contactForm->email = $request->email;
$contactForm->message = $request->message;
$contactForm->save();
```



### Menyimpan via Mass Assigment ⭐

```php
use App\Models\ContactForm;

// Cara paling direkomendasikan, ringkas namun tetap "Eloquent Ways"
ContactForm::create($request->validated());
```

Cara di atas bisa dilakukan hanya jika kita mendefinisikan $guarded atau $fillable di model `ContactForm`.

```php
class ContactForm extends Model
{
    // protected $fillable = ['name', 'email', 'message'];

    protected $guarded = [];
}
```

`$fillable` itu *whitelist*, hanya atribut yang disebutkan disitu yang bisa dilakukan *mass assignment*. Sedangkan `$guarded` bersifat *blacklist*, atribut yang disebutkan disitu tidak boleh dilakukan *mass assignment*.



> #### Laravolt Best Practice
>
> Kosongkan `$guarded` (set sebagai *empty array* seperti contoh di atas), tapi pastikan selalu memanggil `$request->validated()` atau `$request->only()` atau  `$request->except()` **dan bukan**  `$request->all()` di *Controller*. Ini akan membuat *Controller* lebih ringkas dan mudah dibaca.

Referensi: https://medium.com/@sager.davidson/fillable-vs-guarded-hint-they-both-lose-f278bc81dedf



### Menampilkan Pesan Sukses

```php
return redirect()->back()->withSuccess('Pesan telah diterima dan menunggu tindak lanjut.');
```



# Misi 3: Mengirim Email Notifikasi



## Misi

1. Tambahkan validasi server-side
    - [ ] Semua field wajib diisi
    - [ ] Format email harus valid
    - [ ] Panjang pesan minimal 20 karakter
    - [ ] Nama lengkap **minimal 3 suku kata**, jika kurang dari 3 suku kata, menampilkan pesan "Nama harus mengandung 3 suku kata atau lebih"
2. Menyimpan ke database
    - [ ] Membuat migration scripts
    - [ ] Membuat model `\App\Models\ContactForm`
    - [ ] Menyimpan via *query builder*
    - [ ] Menyimpan via *model instance*
    - [ ] Menyimpan via *mass assignment*
        -  $fillable
        -  $guarded
    - [ ] Menampilkan pesan sukses "Pesan telah diterima dan menunggu tindak lanjut"
    - [ ] Kembali ke halaman `contact-form`

3. Notifikasi email ke pengirim
    - [ ] Membuat `Event`
    - [ ] Membuat `Listener`
    - [ ] Mendaftarkan `Event` dan `Listener` di `EventServiceProvider`
    - [ ] Membuat `Notification`