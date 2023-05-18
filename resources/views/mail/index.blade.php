@extends('layouts.app')

@section('content')
    <a href="/mail/create">Sukurti naują laišką</a>
    <h1>Jūsų laiškai:</h1>
    @if(count($mails) >= 1)
        @foreach($mails as $mail)
            <div class="well">
                <h3><a href="/mail/{{$mail->id}}">{{$mail->text}}</a></h3>
            </div>
        @endforeach
    @else
        <p>Nėra laiškų</p>
    @endif
@endsection
