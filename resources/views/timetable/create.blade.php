@extends('layouts.app')

@section('content')
    <h1>Sukurti nauja tvarkarasti</h1>
    {!! Form::open(['action' => '\App\Http\Controllers\TimetableController@store', 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('year', 'Tvarkarascio metai')}}
            {{Form::date('year', \Carbon\Carbon::now())}}
        </div>
        <div class="formGroup">
            {{Form::label('mod_speed', 'Modifikavimo greitis')}}
            {{Form::text('mod_speed', '', ['class' => 'form-control', 'placeholder' => ''])}}
        </div>
        <div class="formGroup">
            {{Form::label('iter', 'Iteracijų skaičius')}}
            {{Form::text('iter', '', ['class' => 'form-control', 'placeholder' => ''])}}
        </div>
        
        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection