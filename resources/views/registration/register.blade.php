@extends('layouts.app')

@section('title', 'Register for Vaccination')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3>Register for COVID-19 Vaccination</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                        </div>

                        <div class="form-group">
                            <label for="nid">National ID (NID)</label>
                            <input type="text" name="nid" id="nid" class="form-control" placeholder="Enter your NID" required>
                        </div>

                        <div class="form-group">
                            <label for="vaccine_center_id">Select Vaccine Center</label>
                            <select name="vaccine_center_id" id="vaccine_center_id" class="form-control" required>
                                @foreach($vaccineCenters as $center)
                                    <option value="{{ $center->id }}">{{ $center->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
