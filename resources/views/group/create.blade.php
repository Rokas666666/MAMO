@extends('layouts.app')

@section('content')
    <h1>Sukurti naują grupę</h1>
    {!! Form::open(['action' => '\App\Http\Controllers\GroupController@store', 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('title', 'Pavadinimas')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Grupė'])}}
        </div>

        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
