@component('mail::message')
    <h1>Salut,</h1>

    Une nouvlle offre a été ajoutée.

    @component('mail::button', ['url' => config('app.url') . '/list-offres'])
        Voir les offres
    @endcomponent

    Cordialement,
    GESTA
@endcomponent
