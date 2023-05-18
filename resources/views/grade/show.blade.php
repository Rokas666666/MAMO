@extends('layouts.app')

@section('content')
    <a href="/grade" class="btn btn-default">Grįžti</a>
    <h1>Pažymio informacija</h1>
    <div class="well">
        <h4>Pažymio vertė: {{$grade->value}}</h4>
    </div>
    <hr>
    <a href="/grade/{{$grade->id}}/edit" class="btn btn-default">Redaguoti</a>

    {!!Form::open(['action' => ['\App\Http\Controllers\GradeController@destroy', $grade->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Ištrinti', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
@endsection
