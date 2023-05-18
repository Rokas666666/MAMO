@extends('layouts.app')

@section('content')
    <h1>Redaguoti modulį</h1>
    {!! Form::open(['action' => ['\App\Http\Controllers\ModuleController@update', $module->id], 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('title', 'Pavadinimas')}}
            {{Form::text('title', $module->title, ['class' => 'form-control', 'placeholder' => 'Pavadinimas'])}}
        </div>
        <div class="formGroup">
            {{Form::label('hours', 'Valandos per savaitę')}}
            {{Form::input('number', 'hours', $module->hours, ['class' => 'form-control', 'placeholder' => 'Valandos per savaitę'])}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
