@extends('layouts.app')

@section('content')
    <h1>Readaguoti tvarkaraščio informaciją</h1>
    {!! Form::open(['action' => ['\App\Http\Controllers\TimetableController@update', $timetable->id], 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('year', 'Tvarkaraščio metai')}}
            {{Form::date('year', \Carbon\Carbon::now())}}
        </div>

        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
