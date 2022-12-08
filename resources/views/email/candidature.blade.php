@component('mail::message')
    <h1>Salut,</h1>

    Une nouvlle candidature a été émise.

    @component('mail::button', ['url' => config('app.url') . 'admin/list-offres'])
        Voir les candidatures
    @endcomponent

    Cordialement,
    GESTA
@endcomponent
