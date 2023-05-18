@extends('layouts.app')

@section('content')
    <h1>Sukurti naują taisyklė</h1>
    {!! Form::open(['action' => '\App\Http\Controllers\RuleController@store', 'method' => 'POST']) !!}
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
            {{Form::select('userID', $teachers, null, ['class' => 'form-control'])}}
        </div>
        <div class="formGroup">
            {{Form::label('restriction', 'Ribojimas')}}
            {{Form::text('restriction', '', ['class' => 'form-control', 'placeholder' => ''])}}
        </div>
        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
