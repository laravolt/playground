# Contact Form

## Mendefinisikan Route
```php
Route::get('contact-form', 'ContactFormController@create')->name('contact-form.create');
Route::post('contact-form', 'ContactFormController@store')->name('contact-form.store');
```

## Membuat Controller

### Jalankan Generator

`php artisan make:controller ContactFormController`

### Tambahkan Method `create` dan `store`

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



## Tambahkan View

Membuat skeleton view di `resources/views/contact-form/create.blade.php`.

```php+HTML
@extends('ui::layouts.centered')
@section('content')

@stop
```

## Membuat Form

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

## Validasi Form

### Generate `FormRequest`

`php artisan make:request ContactForm/Store`

### Modifikasi Isinya

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



### Pasangkan ke `ContactFormController@store`

```php
public function store(\App\Http\Requests\ContactForm\Store $request)
{
    //
}
```



## Misi

1. Tambahkan validasi server-side
    - Semua field wajib diisi
    - Format email harus valid
    - Panjang pesan minimal 20 karakter
    - Nama lengkap **minimal 3 suku kata**, jika kurang dari 3 suku kata, menampilkan pesan "Nama harus mengandung 3 suku kata atau lebih"
2. Menyimpan ke database
    -  Membuat model `ContactForm`
    -  Menyimpan via *query builder*
    -  Menyimpan via *model instance*
    -  Menyiimpan via *mass assignment*
        -  $fillable
        -  $guarded
    -  Menampilkan pesan sukses "Pesan telah diterima dan menunggu tindak lanjut"
    -  Kembali ke halaman `contact-form`

3. Notifikasi email ke pengirim
    - Membuat `Event`
    - Membuat `Listener`
    - Mendaftarkan `Event` dan `Listener`
    - Membuat `Notification`