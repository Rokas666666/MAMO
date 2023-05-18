@extends('layouts.app')

@section('content')
    <a href="/room/create">Registruoti naują kabinetą</a>
    <h1>Kabinetai:</h1>
    @if(count($rooms) >= 1)
        @foreach($rooms as $room)
            <div class="well">
                <h3><a href="/room/{{$room->id}}">{{$room->location}}</a></h3>
            </div>
        @endforeach
    @else
        <p>Nerasta kabinetų</p>
    @endif
@endsection
