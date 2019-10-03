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
