@extends('emails.layout.default')

@section('content')
    <p>Dear {{ $name }},</p>

    <p>Your vaccination is scheduled for <strong>{{ $scheduledDate }}</strong> at <strong>{{ $vaccineCenterName }}</strong>.</p>

    <p>Please remember to bring your National ID (NID) with you and arrive on time.</p>

    <p>Thank you for registering for the COVID-19 vaccine!</p>

    <p>Best regards,<br>COVID-19 Vaccine Registration Team</p>
@endsection
