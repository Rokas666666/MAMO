@extends('layouts.app')

@section('content')
    <h1>Redaguoti taisyklės informaciją</h1>
    {!! Form::open(['action' => ['\App\Http\Controllers\RuleController@update', $rule->id], 'method' => 'POST']) !!}
        <div class="formGroup">
            {{Form::label('dateFrom', 'Taisyklės galiojimo pradžia')}}
            {{Form::date('dateFrom', \Carbon\Carbon::now())}}
        </div>
        <div class="formGroup">
            {{Form::label('dateTo', 'Taisyklės galiojimo pabaiga')}}
            {{Form::date('dateTo', \Carbon\Carbon::now())}}
        </div>
        <div class="formGroup">
            {{Form::label('userID', 'Ribojamas mokytojas')}}
            {{Form::select('userID', $teachers, $rule->userID, ['class' => 'form-control'])}}
        </div>
        <div class="formGroup">
            {{Form::label('restriction', 'Ribojimas')}}
            {{Form::text('restriction', $rule->restriction, ['class' => 'form-control', 'placeholder' => ''])}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
