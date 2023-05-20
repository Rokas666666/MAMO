@extends('layouts.app')

@section('content')
    <h1>Sukurti naują grupę</h1>
    {!! Form::open(['action' => '\App\Http\Controllers\GroupController@store', 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('title', 'Pavadinimas')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Grupė'])}}
        </div>

        <div class="formGroup">
            {{Form::label('users', 'Pasirinkti mokinius')}}
            <br>
            @foreach($users as $user)
                {{Form::checkbox('users[]', $user->id)}}
                {{Form::label('user_'.$user->id, $user->name)}}
                <br>
            @endforeach
        </div>

        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
