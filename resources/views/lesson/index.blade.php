@extends('layouts.app')

@section('content')
    <a href="/lesson/create">Sukurti naują pamoką</a>
    <h1>Pamokos:</h1>
    @if(count($lessons) >= 1)
        @foreach($lessons as $lesson)
            <div class="well">
                <h3><a href="/lesson/{{$lesson->id}}">{{$lesson->time}}</a></h3>
                <small>{{$lesson->comment}}</small>
            </div>
        @endforeach
    @else
        <p>Nerasta pamokų</p>
    @endif

    <!-- Display timetable for each day of the week -->
    <h1>Tvarkaraštis:</h1>
    @php
            $start_date = isset($_GET['start_date']) ? new DateTime($_GET['start_date']) : new DateTime();
            $end_date = clone $start_date;
            $end_date->modify('+7 days');
            $dates = array(); // Array to hold lesson times
        @endphp

        <form method="get" action="{{ route('lesson.index') }}">
            <label for="start_date">Rodyti nuo:</label>
            <input type="date" name="start_date" id="start_date" value="{{ $start_date->format('Y-m-d') }}">
            <button type="submit"  class="btn btn-default">Pasirinkti</button>
        </form>
    <div class="timetable">


        @foreach (new DatePeriod($start_date, new DateInterval('P1D'), $end_date) as $day)
            <!-- Display timetable for the day -->
            <div class="timetable_block">
                @php
                    $carbonDay = \Carbon\Carbon::instance($day);
                    $formattedDay = $carbonDay->locale('lt_LT')->isoFormat('dddd'); // Day of the week (e.g., Monday)
                    $formattedMonth = $carbonDay->locale('lt_LT')->isoFormat('MMMM'); // Month (e.g., January)
                @endphp
                <h5>{{ $day->format('Y-m-d') }}</h5>
                <table>
                    @for ($i = 8; $i < 18; $i++)
                        <tr>
                            <td>{{ $i }}:00</td>

                            <!-- Loop through each hour of the day -->
                            @php
                                $lesson_found = false;
                                $time_slot_start = new DateTime($day->format('Y-m-d ') . sprintf("%02d", $i) . ':00:00');
                                $time_slot_end = new DateTime($day->format('Y-m-d ') . sprintf("%02d", $i) . ':59:59');
                                foreach($lessons as $lesson) {
                                    $lesson_time = new DateTime($lesson->time);
                                    if ($lesson_time >= $time_slot_start && $lesson_time <= $time_slot_end) {
                                        echo '<td><a href="/lesson/' . $lesson->id . '">' . $lesson->comment . '</a></td>';
                                        $lesson_found = true;
                                        break;
                                    }
                                }
                                if (!$lesson_found) {
                                    echo '<td></td>';
                                }
                            @endphp
                        </tr>
                    @endfor
                </table>
            </div>
        @endforeach
    </div>
@endsection
