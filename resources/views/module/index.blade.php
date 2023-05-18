@extends('layouts.app')

@section('content')
    <a href="/module/create">Sukurti naują modulį</a>
    <h1>Moduliai:</h1>
    @if(count($modules) >= 1)
        @foreach($modules as $module)
            <div class="well">
                <h3><a href="/module/{{$module->id}}">{{$module->title}}</a></h3>
            </div>
        @endforeach
    @else
        <p>Nerasta modulių</p>
    @endif
@endsection
