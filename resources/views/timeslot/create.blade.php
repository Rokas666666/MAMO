@extends('layouts.app')

@section('content')
    <h1>Registruoti naują pamokos laiką</h1>
    {!! Form::open(['action' => '\App\Http\Controllers\TimeslotController@store', 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('slot', 'Vieta')}}
            {{Form::text('slot', '', ['class' => 'form-control', 'placeholder' => ''])}}
        </div>
        <div class="formGroup">
            <label for="start">Pamokos laiko pradžia:</label>
            <input type="time" id="start" name="start">
        </div>
        <div class="formGroup">
            {{Form::label('length', 'Pamokos ilgis minutėmis')}}
            {{Form::text('length', '', ['class' => 'form-control', 'placeholder' => ''])}}
        </div>
        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
