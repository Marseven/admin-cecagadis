@component('mail::message')
    <h1>Hello {{ $data['dest_manager'] }},</h1>

    {{ $data['exp'] }} souhaite être partenaire avec {{ $data['dest'] }}.

    @component('mail::button', ['url' => config('app.url') . 'admin/list-demandes'])
        Voir les demandes
    @endcomponent

    Cordialement,
    {{ $data['exp'] }}
    {{ $data['exp_email'] }}
    {{ $data['exp_phone'] }}
@endcomponent
