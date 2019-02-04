<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<style>
    body { font-family: DejaVu Sans, sans-serif;
        font-size: 12pt;
    }
</style>

<body>
    <h2 style="text-align: center;">Amata atskaite.</h2>
    <table>
        <tr>
            <td>
                <p><b>Vārds, Uzvārds:</b></p>
            </td>
            <td>
                <p>{{$user->name}} {{$user->surname}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p><b>Amata nosaukums:&emsp;</b></p>
            </td>
            <td>
                <p>{{$role->role_id}}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p><b>Laika periods: </b></p>
            </td>
            <td>
                <p>{{$role->start_date->toDateString()}} - {{$role->expire_date->toDateString()}}</p>
            </td>
        </tr>
    </table>
    <hr>
    <h2 style="text-align: center">Apraksts</h2>
    <p>{{$role->report}}</p>
</body>
