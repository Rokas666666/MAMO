@extends('layouts.app')

@section('content')
    <h1>Redaguoti pamoką</h1>
    {!! Form::open(['action' => ['\App\Http\Controllers\LessonController@update', $lesson->id], 'method' => 'POST']) !!}
        @csrf
        <label for="module_id">Modulis:</label>
        <select name="module_id" id="module_id">
            @foreach($modules as $module)
                <option value="{{ $module->id }}">{{ $module->title }}</option>
            @endforeach
        </select>
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
            <label for="time">Pamokos pradžia:</label>
            <input type="time" id="time" name="time">
        </div>
        <div class="formGroup">
            {{Form::label('comment', 'Komentaras')}}
            {{Form::textarea('comment', $lesson->comment, ['class' => 'form-control', 'placeholder' => 'Komentaras'])}}
        </div>
        <div class="formGroup">
            {{Form::label('homework', 'Namų darbai')}}
            {{Form::textarea('homework', $lesson->homework, ['class' => 'form-control', 'placeholder' => 'Namų darbai'])}}
        </div>
        <div class="formGroup">
            {{Form::label('test', 'Testo informacija')}}
            {{Form::text('test', $lesson->test, ['class' => 'form-control', 'placeholder' => 'Testas'])}}
        </div>
        <h2>Pažymiai</h2>
        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                <tr>
                    <td>{{ $grade->user_name }}</td>
                    <td>
                        <input type="number" name="grade_values[]" value="{{ $grade->value }}">
                    </td>
                </tr>
                @endforeach
                <!-- Add more rows for each student -->
            </tbody>
        </table>
    {{Form::hidden('_method', 'PUT')}}
    {{Form::submit('Pateikti', ['class' => 'btn btn-dark'])}}
    {!! Form::close() !!}
    
@endsection
