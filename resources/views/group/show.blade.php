@extends('layouts.app')

@section('content')
    <a href="/group" class="btn btn-default">Grįžti</a>
    <h1>Grupės informacija</h1>
    <div class="well">
        <h4>Grupės pavadinimas: {{$group->title}}</h4>
    </div>
    <hr>
    <a href="/group/{{$group->id}}/edit" class="btn btn-default">Redaguoti</a>

    {!!Form::open(['action' => ['\App\Http\Controllers\GroupController@destroy', $group->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Pašalinti', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
@endsection
