@component('mail::message')
# {{ $team->name }} Report

@if(isset($reports))
@foreach($reports as $report)
@component('mail::panel')
<h2>{{ $report['user_title'] }}: {{ $report['report']['total_time'] }}</h2>
<hr/>

@if(isset($report['report']['worklogs']) && is_array($report['report']['worklogs']))
@foreach($report['report']['worklogs'] as $worklog)
<strong>{{ $worklog['issue'] }}:</strong> {{ $worklog['time'] }}

@if(isset($worklog['description']) && is_array($worklog['description']))
@foreach($worklog['description'] as $description)
{{ $description }}
@endforeach
@endif

<br/>
@endforeach
@endif
@endcomponent
@endforeach
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
