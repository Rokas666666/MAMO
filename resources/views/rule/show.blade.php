@extends('layouts.app')

@section('content')
    <a href="/rule" class="btn btn-default">Grįžti</a>
    <h1>Taisyklės informacija</h1>
    <div class="well">
        <h4>Taisyklės pradžia: {{$rule->dateFrom}}</h4>
        <h4>Taisyklės pabaiga: {{$rule->dateTo}}</h4>
        <h4>Taisyklės ribojimas: {{$rule->restriction}}</h4>
        <h4>Mokytojas: {{$user->name}}</h4>
    </div>
    <hr>
    <a href="/rule/{{$rule->id}}/edit" class="btn btn-default">Redaguoti</a>

    {!!Form::open(['action' => ['\App\Http\Controllers\RuleController@destroy', $rule->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Pašalinti', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
@endsection
