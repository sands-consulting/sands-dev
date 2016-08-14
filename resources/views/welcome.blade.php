<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Social -->
    <title>Sands Consulting Developer's Portal</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ elixir('css/login.css') }}">
</head>
<body>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-xs-12  hidden-xs">
                <div class="pull-left text-center">
                    <img src="/images/logo.png" class="login-logo">
                </div>
                <div>
                    <h1>Sands Developer Portal</h1>
                    <p>Sands Consulting Sdn. Bhd.</p>
                </div>
            </div>
            <div class="col-xs-12 visible-xs hidden-sm">
                <div class="text-center">
                    <img src="/images/logo.png" class="login-logo">
                    <h1>Sands Developer Portal</h1>
                    <p>Sands Consulting Sdn. Bhd.</p>
                </div>
            </div>
        </div>
        <hr>
        @if(Session::has('error'))
            <div class="alert alert-danger" role="alert">
                {{Session::get('error')['message']}}
            </div>
        @endif
        <br>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <a href="/login/github" class="btn btn-primary btn-lg btn-primary btn-block">
                <i class="fa fa-github"></i>
                Login With Github Account
            </a>
            <br>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <a href="/login/google" class="btn btn-primary btn-lg btn-primary btn-block">
                <i class="fa fa-google"></i>
                Login With Google Account
            </a>
        </div>
    </div>
</body>
</html>
