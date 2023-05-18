@extends('layouts.app')

@section('content')
    <a href="/grade/create">Sukurti naują pažymį</a>
    <h1>Pažymiai:</h1>
    @if(count($grades) >= 1)
        @foreach($grades as $grade)
            <div class="well">
                <h3><a href="/grade/{{$grade->id}}">{{$grade->value}}</a></h3>
            </div>
        @endforeach
    @else
        <p>Nerasta pažymių</p>
    @endif
@endsection
