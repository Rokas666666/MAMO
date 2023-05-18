@extends('layouts.app')

@section('content')
    <a href="/timetable/create">Sukurti naują tvarkaraštį</a>
    <h1>Tvarkarasciu archyvas:</h1>
    @if(count($timetables) >= 1)
        @foreach($timetables as $timetable)
            <div class="well">
                <h3><a href="/timetable/{{$timetable->id}}">{{$timetable->year}}</a></h3>
            </div>
        @endforeach
    @else
        <p>Nerasta tvarkaraščių</p>
    @endif
@endsection
