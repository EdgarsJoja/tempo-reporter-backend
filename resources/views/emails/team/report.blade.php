@component('mail::message')
# Team Report

Test text

@component('mail::button', ['url' => ''])
    Button
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
