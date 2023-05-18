@extends('layouts.app')

@section('content')
    <h1>Registruoti naują kabinetą</h1>
    {!! Form::open(['action' => '\App\Http\Controllers\RoomController@store', 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('location', 'Title')}}
            {{Form::text('location', '', ['class' => 'form-control', 'placeholder' => 'Kabinetas'])}}
        </div>

        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
