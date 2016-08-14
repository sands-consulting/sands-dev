<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sands Consulting Developer's Portal</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

    <style type="text/css">
        .login-logo {
            margin-top: 10px;
            height: 90px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <br>
    <div class="container">
        <div class="clearfix">
            <img src="/assets/images/logo.png" class="pull-left login-logo">
            <div>
                <h1>Sands Developer Portal</h1>
                <p>It's bare because we like it that way</p>
            </div>
        </div>
        <hr>
        @if(Session::has('error'))
            <div class="alert alert-danger" role="alert">
                {{Session::get('error')['message']}}
            </div>
        @endif
        <br>
        <a href="/login" class="btn btn-primary">
            <i class="fa fa-github"></i>
            Login With Github
        </a>

    </div>
</body>
</html>
