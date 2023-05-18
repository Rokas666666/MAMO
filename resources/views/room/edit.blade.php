@extends('layouts.app')

@section('content')
    <h1>Redaguoti kabineto duomenis</h1>
    {!! Form::open(['action' => ['\App\Http\Controllers\RoomController@update', $room->id], 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('location', 'Pavadinimas')}}
            {{Form::text('location', $room->location, ['class' => 'form-control', 'placeholder' => 'Pavadinimas'])}}
        </div>

        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
