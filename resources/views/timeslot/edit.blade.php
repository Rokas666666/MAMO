@extends('layouts.app')

@section('content')
    <h1>Redaguoti pamokos laiko informacija</h1>
    {!! Form::open(['action' => ['\App\Http\Controllers\TimeslotController@update', $timeslot->id], 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('slot', 'Vieta')}}
            {{Form::text('slot', $timeslot->slot, ['class' => 'form-control', 'placeholder' => ''])}}
        </div>
        <div class="formGroup">
            <label for="start">Pamokos laiko pradžia:</label>
            <input type="time" id="start" name="start">
        </div>
        <div class="formGroup">
            {{Form::label('length', 'Pamokos ilgis minutėmis')}}
            {{Form::text('length', $timeslot->length, ['class' => 'form-control', 'placeholder' => ''])}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
