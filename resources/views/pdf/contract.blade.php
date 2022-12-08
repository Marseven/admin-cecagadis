<html>

<head>
    <style>
        body {
            font-family: Verdana, Arial;
            font-size: 11pt;
        }

        h1 {
            color: #2F5496;
            margin: 8px 0 2px 0;
            font-size: 16pt;
            font-weight: normal;
        }

        h2 {
            color: #2F5496;
            margin: 8px 0 2px 0;
            font-size: 13pt;
            font-weight: normal;
        }

        h3 {
            color: #2F5496;
            margin: 8px 0 2px 0;
            font-size: 12pt;
            font-weight: normal;
        }

        h4 {
            color: #2F5496;
            margin: 8px 0 2px 0;
            font-size: 11pt;
            font-weight: normal;
            font-style: italic;
        }

        ol,
        ul {
            padding-left: 50px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table tr td {
            border: 1px solid #000000;
            padding: 4px;
        }

        .logo {
            width: 40%;
            height: auto;
            display: inline-block;
            margin-left: 25.00px;
            margin-top: 0.00px;
            transform: rotate(0.00rad) translateZ(0px);
            -webkit-transform: rotate(0.00rad) translateZ(0px);
        }

        .container {
            display: flex;
        }
    </style>
</head>

<body>
    <div class="container" style="text-align:center;">
        <div style="display: inline-block;text-align:center;"> <img class="logo" alt="Sigalli"
                src="{{ asset('admin/images/logo-sigali.png') }}" title="Sigali"></div>
        <div style="display: inline-block;">
            <p style="text-align:center;">
                <strong>Société Industrielle Gabonaise de Laiterie et de Liquides</strong>
            </p>
        </div>
    </div>
    <p style="text-align:right;">Libreville le, {{ $date }}</p>
    <p style="text-align:center;"><strong>Le </strong><strong>Directeur Commercial</strong></p>
    <p style="text-align:center;"><strong>A </strong></p>
    <p style="text-align:center;"><strong>{{ $contract->intern->gender == 'H' ? 'Monsieur' : 'Madame' }}
            {{ $contract->intern->lastname }}
            {{ $contract->intern->firstname }}</strong></p>
    <p style="text-align:center;"><strong><u>Libreville</u></strong></p>
    <p><strong><u>Objet :</u></strong> Votre demande de stage</p>
    <p><strong>{{ $contract->intern->gender == 'H' ? 'Monsieur' : 'Madame' }},</strong></p>
    <p style="text-align:justify;"><strong></strong>Suite à votre correspondance relative à une demande de stage au sein
        de notre Administration,
        j’ai le plaisir de vous informer que celle-ci a reçu un avis favorable.</p>
    <p style="text-align:justify; padding-left:0px;">Ainsi, vous effectuerez votre stage à la
        <strong>{{ $contract->departement }}</strong>,
        précisément au poste <strong>{{ $contract->poste }}</strong> du service du
        <strong>{{ $contract->begin }}</strong> au
        <strong>{{ $contract->end }}</strong>.
    </p>
    <p style=" text-align:justify; padding-left:0px;">Si les conditions d’entretien sont à votre convenance, nous
        attendons en retour votre
        convention de stage pour finaliser le processus d’insertion au sein de notre structure.</p>
    <p style="text-align:justify; padding-left:0px;">Veuillez agréer, Monsieur, nos salutations distinguées.</p>
    <p style="padding-left:0px;">&nbsp;</p>
    <p style="padding-left:0px;">&nbsp;</p>
    <p style="padding-left:0px;">&nbsp;</p>
    <p style="text-align:center; padding-left:424px;"><span>Anthony SALAS</span></p>
    <p style="text-align:center; padding-left:424px;"><span> </span><span>Directeur Commercial</span></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <hr>
    <p style="text-align:center; font-size: 10px;">
        Siège Social : B.P.68 – Z.I. Oloumi – Libreville – Gabon – Tél. 01 76 13 69 / 01 76 13 71 / 01 77 49 90
        (Commercial)
    </p>
    <p style="text-align:center; font-size: 10px;">
        Fax. 01 72 59 60 / 01 72 63 49 – E-mail : secretariat@sigalli.com – URL : www.sigalli.com.
    </p>

</body>

</html>
