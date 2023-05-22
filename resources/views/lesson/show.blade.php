@extends('layouts.app')

@section('content')
    <a href="/lesson" class="btn btn-default">Grįžti</a>
    <h1>Pamokos informacija</h1>
    <div class="well">
        <h4>Modulis: {{$moduleLesson->title}}</h4>
        <h4>Kabinetas: {{$roomLesson->location}}</h4>
        <h4>Pamokos laikas: {{$lesson->time}}</h4>
        <h4>Komentaras: {{$lesson->comment}}</h4>
        <h4>Namų darbai: {{$lesson->homework}}</h4>
        <h4>Testas: {{$lesson->test}}</h4>
    </div>

    <h2>Pažymiai</h2>
        <table>
            <thead>
                <tr>
                    <th>Mokinys</th>
                    <th>Pažymys</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                <tr>
                    <td>{{ $grade->user_name }}</td>
                    <td>{{ $grade->value }}</td>
                </tr>
                @endforeach
                <!-- Add more rows for each student -->
            </tbody>
        </table>
    <hr>
    @if (Auth::user()->role >= 2)
        <a href="/lesson/{{$lesson->id}}/edit" class="btn btn-default">Redaguoti</a>

        {!!Form::open(['action' => ['\App\Http\Controllers\LessonController@destroy', $lesson->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Pašalinti', ['class' => 'btn btn-danger'])}}
        {!!Form::close()!!}
    @endif
@endsection
