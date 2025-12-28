<x-mail::message>
# {{ $mailSubject }}

{{ $mailBody }}

<x-mail::button :url="''">
عرض التفاصيل
</x-mail::button>

شكرًا لك،<br>
{{ config('app.name') }}
</x-mail::message>
