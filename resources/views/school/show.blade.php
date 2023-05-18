@extends('layouts.app')

@section('content')
    <a href="/school" class="btn btn-default">Grįžti</a>
    <h1>Mokyklos informacija</h1>
    <div class="well">
        <h4>Mokyklos pavadinimas: {{$school->title}}</h4>
        <h4>Mokyklos adresas: {{$school->address}}</h4>
    </div>
    <hr>
    <a href="/school/{{$school->id}}/edit" class="btn btn-default">Redaguoti</a>

    {!!Form::open(['action' => ['\App\Http\Controllers\SchoolController@destroy', $school->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Pašalinti', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
@endsection
