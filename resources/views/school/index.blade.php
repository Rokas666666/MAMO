@extends('layouts.app')

@section('content')
    <a href="/school/create">Registruoti naują mokyklą</a>
    <h1>Mokyklos:</h1>
    @if(count($schools) >= 1)
        @foreach($schools as $school)
            <div class="well">
                <h3><a href="/school/{{$school->id}}">{{$school->title}}</a></h3>
            </div>
        @endforeach
    @else
        <p>Nerasta mokyklų</p>
    @endif
@endsection
