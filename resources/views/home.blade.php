@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="jumbotron text-center bg-white shadow-sm p-5">
        <h1 class="display-4" style="color: #F26D3E;">Welcome to the COVID-19 Vaccine Registration System</h1>
        <p class="lead text-dark">Register today to schedule your vaccination and help protect our community.</p>
        <hr class="my-4">
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="{{ route('register') }}" role="button">Register Now</a>
            <a class="btn btn-success btn-lg" href="{{ route('search') }}" role="button">Check Vaccination Status</a>
        </p>
    </div>
@endsection
