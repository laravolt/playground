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

