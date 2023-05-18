@extends('layouts.app')

@section('content')
    <h1>Redaguoti laiško informaciją</h1>
    {!! Form::open(['action' => ['\App\Http\Controllers\MailController@update', $mail->id], 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('text', 'Tekstas:')}}
            {{Form::textarea('text', $mail->text, ['class' => 'form-control', 'placeholder' => ''])}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
