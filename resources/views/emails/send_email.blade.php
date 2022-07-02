@component('mail::message')
    # {{ $details['title'] }}
    {{ $details['name'] }}
    {{ $details['email'] }}
    {{ $details['phone'] }}

    {{ $details['body'] }}.

    @component('mail::button', ['url' => 'https://golden-soft.online/'])
        Visit Our Website
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
