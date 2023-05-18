@extends('layouts.app')

@section('content')
    <a href="/module" class="btn btn-default">Grįžti</a>
    <h1>Modulio informacija</h1>
    <div class="well">
        <h4>Pavadinimas: {{$module->title}}</h4>
        <h4>Valandų kiekis per savaitę: {{$module->hours}}</h4>
    </div>
    <hr>
    <h4>Modulio pamokos: </h4>
    @foreach ($module->lessons as $lesson)
        <h5>{{$lesson->time}}</h5>
        <h5>{{$lesson->homework}}</h5>
    @endforeach
    <hr>
    <a href="/module/{{$module->id}}/edit" class="btn btn-default">Redaguoti</a>

    {!!Form::open(['action' => ['\App\Http\Controllers\ModuleController@destroy', $module->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Pašalinti', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
@endsection
