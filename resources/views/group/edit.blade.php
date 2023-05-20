@extends('layouts.app')

@section('content')
    <h1>Redaguoti grupę</h1>
    {!! Form::open(['action' => ['\App\Http\Controllers\GroupController@update', $group->id], 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('title', 'Pavadinimas')}}
            {{Form::text('title', $group->title, ['class' => 'form-control', 'placeholder' => 'Grupė'])}}
        </div>

        <div class="formGroup">
            {{Form::label('users', 'Pasirinkti mokinius')}}
            <br>
            @foreach($users as $user)
                {{Form::checkbox('users[]', $user->id, $group->users->contains($user->id))}}
                {{Form::label('user_'.$user->id, $user->name)}}
                <br>
            @endforeach
        </div>

        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
