<html>

<head>
    <style>
        body {
            font-family: Verdana, Arial;
            font-size: 12pt;
        }

        h1 {

            margin: 8px 0 2px 0;
            font-size: 16pt;
            font-weight: normal;
        }

        h2 {
            margin: 8px 0 2px 0;
            font-size: 13pt;
            font-weight: normal;
        }

        h3 {
            margin: 8px 0 2px 0;
            font-size: 12pt;
            font-weight: normal;
        }

        h4 {
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
    <p><strong><u></u></strong></p>

    <h1 style="border: #000000 1px solid; padding: 10px; text-align:center; color:#000000; font-size:40px;">
        <strong>ATTESTATION DE FIN DE STAGE</strong>
    </h1>

    <p>&nbsp;</p>

    <p style="text-align:justify;"><span>Nous soussignés, la société Anonyme SIGALLI, représentée par le Directeur
            Général Adjoint,
        </span><strong>Monsieur Bertrand COURTIES, </strong><span>attestons que,
            {{ $contract->intern->gender == 'H' ? 'Monsieur' : 'Madame' }}
        </span><strong>{{ $contract->intern->lastname }}
            {{ $contract->intern->firstname }}, </strong><span> a effectué un stage école au
        </span><strong>{{ $contract->departement }}
            au poste de {{ $contract->poste }}</strong><span> sous la supervision de Monsieur
            Anthony SALAS.</span></p>
    <p>Période : du <strong>{{ $contract->begin }} au {{ $contract->end }}</strong></p>
    <p>La présente Attestation est établie pour servir et valoir ce que de droit.</p>
    <p>&nbsp;</p>
    <p style="text-align:right;">Fait
        à Libreville, le {{ $date }}</p>
    <p>&nbsp;</p>
    <p style="text-align:right;">Bertrand COURTIES</p>
    <p style="text-align:right;"><strong>Directeur Général Adjoint</strong></p>
    <p style="text-align:right;"><img class="logo" alt="signature" src="{{ asset('admin/images/signature.jpg') }}"
            title="Signature"></p>
    <p>&nbsp;</p>
    <p style="padding-left:0px;">&nbsp;</p>
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
