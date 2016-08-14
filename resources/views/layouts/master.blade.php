<!DOCTYPE html>
<html lang="en">
    <head>
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
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Sands Consulting Developer's Portal</title>

        <link rel="stylesheet" href="{{ elixir('css/app.css') }}">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        @yield('styles')
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Dev Portal</a>
                </div>

                <div id="navbar" class="collapse navbar-collapse">
                  <ul class="nav navbar-nav navbar-right">
                    <li class="visible-xs visible-sm {{($__table == 'dashboard' ? 'active': '')}}"><a href="/">Dashboard</a></li>
                    <li class="visible-xs visible-sm {{($__table == 'applications' ? 'active': '')}}"><a href="{{action('ApplicationsController@getIndex')}}">Applications</a></li>
                    <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Logout {{auth()->user()->nickname}}</a></li>
                  </ul>
                </div>
                <ul class="nav navbar-nav navbar-right hidden-xs">
                </ul>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 visible-md visible-lg sidebar">
                    <ul class="nav nav-sidebar">
                        <li class="{{($__table == 'dashboard' ? 'active': '')}}"><a href="/">Dashboard</a></li>
                        <li class="{{($__table == 'applications' ? 'active': '')}}"><a href="{{action('ApplicationsController@getIndex')}}">Applications</a></li>
                    </ul>
                </div>
                <div class="col-md-10 col-md-offset-2 main">
                    @yield('content')
                </div>
            </div>
        </div>

        <script src="{{ elixir('js/app.js') }}"></script>
        @yield('scripts')
    </body>
</html>
