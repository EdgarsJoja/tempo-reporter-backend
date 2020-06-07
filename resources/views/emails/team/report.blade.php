@component('mail::message')
# {{ $team->name }} Report

Test text

@component('mail::button', ['url' => ''])
    Button
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
