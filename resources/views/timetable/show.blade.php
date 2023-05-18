@extends('layouts.app')

@section('content')
    <a href="/timetable" class="btn btn-default">Grįžti</a>
    <h1>Tvarkaraščio informacija</h1>
    <div class="well">
        <h4>Tvarkaraščio metai: {{$timetable->year}}</h4>
    </div>
    <hr>
    <a href="/timetable/{{$timetable->id}}/edit" class="btn btn-default">Redaguoti</a>

    {!!Form::open(['action' => ['\App\Http\Controllers\TimetableController@destroy', $timetable->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Pašalinti', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
@endsection
