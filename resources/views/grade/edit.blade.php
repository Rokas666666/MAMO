@extends('layouts.app')

@section('content')
    <h1>Redaguoti pažymio informaciją</h1>
    {!! Form::open(['action' => ['\App\Http\Controllers\GradeController@update', $grade->id], 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('value', 'value')}}
            {{Form::text('value', $grade->value, ['class' => 'form-control', 'placeholder' => 'Pažymys'])}}
        </div>

        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
