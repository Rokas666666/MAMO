@extends('layouts.app')

@section('content')
    <h1>Sukurti naują modulį</h1>
    {!! Form::open(['action' => '\App\Http\Controllers\ModuleController@store', 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('title', 'Pavadinimas')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Pavadinimas'])}}
        </div>
        <div class="formGroup">
            {{Form::label('hours', 'Valandos per savaitę')}}
            {{Form::input('number', 'hours', '', ['class' => 'form-control', 'placeholder' => 'Valandos'])}}
        </div>
        <div class="formGroup">
            {{Form::label('group_id', 'Grupė')}}
            {{Form::select('group_id', $groups, null, ['class' => 'form-control'])}}
        </div>
        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
