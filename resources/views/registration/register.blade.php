@extends('layouts.app')

@section('title', 'Vaccine Registration')

@section('content')
    <h1>Register for COVID-19 Vaccination</h1>

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div>
            <label for="nid">National ID (NID):</label>
            <input type="text" name="nid" id="nid" required>
        </div>

        <div>
            <label for="vaccine_center_id">Select Vaccine Center:</label>
            <select name="vaccine_center_id" id="vaccine_center_id" required>
                @foreach($vaccineCenters as $center)
                    <option value="{{ $center->id }}">{{ $center->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit">Register</button>
    </form>
@endsection
