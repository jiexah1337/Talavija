<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}"/>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic%7CMontserrat:400,700%7CDroid+Sans+Mono:regular">
    <script src="https://use.fontawesome.com/e7598dbc40.js"></script>

    <title>{{ config('app.name') }}</title>
</head>
<body>
<div class="container-fluid">
    <div>
        <h4>Sveiks(-a), {{$user->name}} {{$user->surname}}! </h4>
        Jūs esat reģistrēti Talavija sistēmā!
        Lai aktivizētu savu kontu spiediet šeit:
        <a href="{{route('activateUser', ['userId' => $user->getUserId(), 'activationCode' => $activation->code])}}">Aktivizēt kontu!</a>
        Ja jūs esat parliecināti par to, ka šis e-pasts nosūtīts kļūdaini, droši varat to ignorēt!
    </div>
</div>
</body>
</html>