@extends('layouts.app')

@section('content')
    <h1>Redaguoti mokyklos informaciją</h1>
    {!! Form::open(['action' => ['\App\Http\Controllers\SchoolController@update', $school->id], 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('title', 'Pavadinimas')}}
            {{Form::text('title', $school->title, ['class' => 'form-control', 'placeholder' => ''])}}
        </div>
        <div class="formGroup">
            {{Form::label('address', 'Adresas')}}
            {{Form::text('address', $school->address, ['class' => 'form-control', 'placeholder' => ''])}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
