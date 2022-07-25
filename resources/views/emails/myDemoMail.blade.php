@component('mail::message')
# {{ $details['title'] }}
Dear {{ $details['name'] }}<br>

{{ $details['message'] }}<br>

Regards
@endcomponent
