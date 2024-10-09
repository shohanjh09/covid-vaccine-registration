@component('mail::message')
    # Your COVID-19 Vaccination is Scheduled

    Dear {{ $user->name }},

    Your vaccination is scheduled for **{{ $scheduledDate }}** at **{{ $vaccineCenter->name }}**.

    Please remember to bring your National ID (NID) with you and arrive on time.

    Thank you for registering for the COVID-19 vaccine!

    Best regards,
    COVID-19 Vaccine Registration Team
@endcomponent
