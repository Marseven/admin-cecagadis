@component('mail::message')
    <h1>Hello {{ $data['dest_manager'] }},</h1>

    {{ $data['exp'] }} a accepté votre demande de partenaire.

    Cordialement,
    {{ $data['exp'] }}
    {{ $data['exp_email'] }}
    {{ $data['exp_phone'] }}
@endcomponent
