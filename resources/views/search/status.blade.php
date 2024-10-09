@extends('layouts.app')

@section('title', 'Vaccination Status')

@section('content')
    <h1>Check Vaccination Status</h1>

    <form action="{{ route('search') }}" method="GET">
        <label for="nid">Enter Your NID:</label>
        <input type="text" name="nid" id="nid" required>
        <button type="submit">Search</button>
    </form>

    @if(isset($status))
        <div>
            <h2>Status: {{ $status }}</h2>
            @if($status == 'Scheduled')
                <p>Your vaccination is scheduled for {{ $scheduledDate }}.</p>
            @elseif($status == 'Not registered')
                <p>You are not registered yet. <a href="{{ route('register') }}">Register here</a>.</p>
            @elseif($status == 'Vaccinated')
                <p>You have already been vaccinated on {{ $vaccinatedDate }}.</p>
            @endif
        </div>
    @endif
@endsection
