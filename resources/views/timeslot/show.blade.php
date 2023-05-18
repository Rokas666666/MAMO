@extends('layouts.app')

@section('content')
    <a href="/timeslot" class="btn btn-default">Grįžti</a>
    <h1>Pamokos laiko informacija</h1>
    <div class="well">
        <h4>Vieta: {{$timeslot->slot}}</h4>
        <h4>Pradžia: {{$timeslot->start}}</h4>
        <h4>Ilgis: {{$timeslot->length}}</h4>
    </div>
    <hr>
    <a href="/timeslot/{{$timeslot->id}}/edit" class="btn btn-default">Redaguoti</a>

    {!!Form::open(['action' => ['\App\Http\Controllers\TimeslotController@destroy', $timeslot->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Pašalinti', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
@endsection
