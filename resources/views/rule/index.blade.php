@extends('layouts.app')

@section('content')
    <a href="/rule/create">Sukurti naują taisyklę</a>
    <h1>Taisyklių archyvas:</h1>
    @if(count($rules) >= 1)
        @foreach($rules as $rule)
            <div class="well">
                <h3><a href="/rule/{{$rule->id}}">{{$rule->userID}}:{{$rule->restriction}}</a></h3>
            </div>
        @endforeach
    @else
        <p>Nerasta taisyklių</p>
    @endif
@endsection
