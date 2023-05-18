@extends('layouts.app')

@section('content')
    <h1>Registruoti naują mokyklą</h1>
    {!! Form::open(['action' => '\App\Http\Controllers\SchoolController@store', 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('title', 'Pavadinimas')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => ''])}}
        </div>
        <div class="formGroup">
            {{Form::label('address', 'Adresas')}}
            {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => ''])}}
        </div>
        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
