@extends('layouts.app')

@section('content')
    <h1>Sukurti naują pamoką</h1>
    {!! Form::open(['action' => '\App\Http\Controllers\LessonController@store', 'method' => 'POST']) !!}
        @csrf
        <label for="module_id">Modulis:</label>
        <select name="module_id" id="module_id">
            @foreach($modules as $module)
                <option value="{{ $module->id }}">{{ $module->title }}</option>
            @endforeach
        </select>
        <br>
        @csrf
        <label for="room_id">Kabinetas:</label>
        <select name="room_id" id="room_id">
            @foreach($rooms as $room)
                <option value="{{ $room->id }}">{{ $room->location }}</option>
            @endforeach
        </select>
        <div class="formGroup">
            {{Form::label('date', 'Pamokos data:')}}
            {{Form::date('date', \Carbon\Carbon::now())}}
        </div>
        <div class="formGroup">
            <label for="time" >Pamokos pradžia:</label>
            <input type="time" id="time" name="time">
        </div>
        <label for="timeslot_id" >Pamokos pradžia:</label>
        <select name="timeslot_id" id="timeslot_id">
            @foreach($timeslots as $timeslot)
                <option value="{{ $timeslot->id }}">{{ $timeslot->slot }}</option>
            @endforeach
        </select>
        <div class="formGroup">
            {{Form::label('comment', 'Komentaras')}}
            {{Form::textarea('comment', '', ['class' => 'form-control', 'placeholder' => 'Komentaras'])}}
        </div>
        <div class="formGroup">
            {{Form::label('homework', 'Namų darbai')}}
            {{Form::textarea('homework', '', ['class' => 'form-control', 'placeholder' => 'Namų darbai'])}}
        </div>
        <div class="formGroup">
            {{Form::label('test', 'Testo informacija')}}
            {{Form::text('test', '', ['class' => 'form-control', 'placeholder' => 'Testas'])}}
        </div>

        {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
@endsection
