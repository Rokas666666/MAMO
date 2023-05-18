@extends('layouts.app')

@section('content')
    <h1>Sukurti naują pažymį</h1>
    {!! Form::open(['action' => '\App\Http\Controllers\GradeController@store', 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('value', 'Pažymys')}}
            {{Form::text('value', '', ['class' => 'form-control', 'placeholder' => ''])}}
        </div>

        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
