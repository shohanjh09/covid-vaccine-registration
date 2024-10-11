@extends('layouts.app')

@section('title', 'Check Vaccination Status')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3>Check Your Vaccination Status</h3>
                </div>
                <div class="card-body">
                    @include('components.alert')

                    <form action="{{ route('search.status') }}" method="GET">
                        <div class="form-group">
                            <label for="nid">Enter Your National ID (NID)</label>
                            <input type="number" name="nid" id="nid" class="form-control" placeholder="Enter your NID" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Check Status</button>
                    </form>

                    @if(isset($status))
                        <div class="mt-4 alert alert-info text-center">
                            <h4>Status: {{ $status }}</h4>
                            @if($status == 'Scheduled')
                                <p>Your vaccination is scheduled for {{ $scheduledDate }}.</p>
                            @elseif($status == 'Not registered')
                                <p>You are not registered yet. <a href="{{ route('register') }}" class="btn btn-link">Register here</a>.</p>
                            @elseif($status == 'Vaccinated')
                                <p>You have already been vaccinated on {{ $vaccinatedDate }}.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
