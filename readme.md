# Contact Form



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



## Misi

1. Tambahkan validasi server-side
    - [ ] Semua field wajib diisi
    - [ ] Format email harus valid
    - [ ] Panjang pesan minimal 20 karakter
    - [ ] Nama lengkap **minimal 3 suku kata**, jika kurang dari 3 suku kata, menampilkan pesan "Nama harus mengandung 3 suku kata atau lebih"
2. Menyimpan ke database
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
    - [ ] Mendaftarkan `Event` dan `Listener`
    - [ ] Membuat `Notification`