@extends('layouts.app')

@section('content')
    <a href="/room" class="btn btn-default">Grįžti</a>
    <h1>Kabineto informacija</h1>
    <div class="well">
        <h4>Pavadinimas: {{$room->location}}</h4>
    </div>
    <hr>
    <a href="/room/{{$room->id}}/edit" class="btn btn-default">Redaguoti</a>

    {!!Form::open(['action' => ['\App\Http\Controllers\RoomController@destroy', $room->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Pašalinti', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
@endsection
