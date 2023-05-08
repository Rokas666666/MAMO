@extends('layouts.app')

@section('content')
    <a href="/timeslot/create">Uzregistruoti nauja pamokos laika</a>
    <h1>Pamokos laikai:</h1>
    @if(count($timeslots) >= 1)
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Pradžia</th>
                <th>Pabaiga</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($timeslots as $timeslot)
            <tr>
                <td>{{$timeslot->slot}}</td>
                <td>{{$timeslot->start}}</td>
                <td>{{$timeslot->end()}}</td>
                <td><a href="/timeslot/{{$timeslot->id}}">Keisti</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
        <p>Nerasta pamokos laiku</p>
    @endif
@endsection