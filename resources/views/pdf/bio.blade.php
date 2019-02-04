<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<style>
    body { font-family: DejaVu Sans, sans-serif;
    font-size: 10pt;
    }
</style>

<body>
    <table style="width: 100%">
        <colgroup>
            <col style="width: 35%">

        </colgroup>
        <tr>
            <td colspan="10"></td>
        </tr>
        {{--MEMBER ID - FULL NAME--}}
        <tr>
            <td>Tal.{{$user->member_id}}</td>
            <td colspan="9">{{$user->status()->abbreviation}} {{$user->name}} {{$user->surname}}<br></td>
        </tr>

        {{--BIRTH DATA--}}
        <tr>
            <td rowspan="9">
                <img src="{{storage_path()}}/app/public/avatars/{{md5($user->member_id)}}.png" width="1000%" onerror="this.src='{{asset('img/profile-placeholder.jpg')}}'">
                {{--<img src="storage/avatars/{{md5($user->member_id)}}.png" onerror="this.src='{{asset('img/profile-placeholder.jpg')}}'">--}}
                {{--<img src="{{$_SERVER["DOCUMENT_ROOT"]}}/avatars/{{md5($user->member_id)}}.png" onerror="this.src='{{asset('img/profile-placeholder.jpg')}}'">--}}
            </td>
            <td>Dzimšanas dati: </td>
            <td colspan="2">
                @if($user->bio->birthdata !== null)
                    @if(null !== $user->bio->birthdata->date())
                        {{$user->bio->birthdata->date()}}
                    @endif
                @endif
            </td>
            <td colspan="6">
                <?php
                if(isset($user->bio->birthdata->location))
                {
                    $location = $user->bio->birthdata->location;
                    if($location != null){
                        $address = $location->address;
                        $city = $location->city;
                        $country = $location->country;
                        $notes = $location->notes;

                        $locString = implode(', ', array_filter([$address,$city,$country,$notes]));
                    }
                    echo $locString;
                    $locString = null;
                }
                ?>
            </td>
        </tr>

        {{--DEATH DATA--}}
        <tr>
            <td>Nāves dati: </td>
            <td colspan="2">
                @if($user->bio->birthdata !== null)
                    @if(null !== $user->bio->deathdata->date())
                        {{$user->bio->deathdata->date()}}
                    @endif
                @endif
            </td>
            <td colspan="6">
                <?php
                if(isset($user->bio->deathdata->location))
                {
                    $location = $user->bio->deathdata->location;
                    if($location != null){
                        $address = $location->address;
                        $city = $location->city;
                        $country = $location->country;
                        $notes = $location->notes;

                        $locString = implode(', ', array_filter([$address,$city,$country,$notes]));
                    }
                    echo $locString;
                    $locString = null;
                }
                ?>
            </td>
        </tr>

        {{--V!K! date - Sp!K! date--}}
        <tr>
            <td>V!K!<br></td>
            <td colspan="2">{{$user->start_date()}}</td>
            <td>Sp!K!</td>
            <td colspan="2">{{$user->spk_date()}}</td>
            <td colspan="3">Semestri T! - <br></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">filistrējās</td>
            <td></td>
            <td colspan="2">{{$user->fil_date()}}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">komisāts<br></td>
            <td></td>
            <td colspan="2">dd.mm.gggg</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        {{--OLDERMAN - COL FATHER--}}
        <tr>
            <td colspan="2">Oldermanis</td>
            <td colspan="3">{{$user->bio->olderman->name or ''}} {{$user->bio->olderman->surname or ''}}</td>
            <td colspan="2">krāsu tēvs</td>
            <td>{{$user->bio->colfather->name or ''}} {{$user->bio->colfather->surname or ''}}</td>
            <td></td>
        </tr>

        {{--GROUP OLDERMAN - COL MOTHER--}}
        <tr>
            <td colspan="2">Kopas oldermanis<br></td>
            <td colspan="3">vārds, uzvārds<br></td>
            <td colspan="2">krāsu māte<br></td>
            <td>{{$user->bio->colmother->name or ''}} {{$user->bio->colmother->surname or ''}}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="10"></td>
        </tr>
    </table>

    <table style="width: 100%">
        <colgroup>
            <col style="width: 50%">
            <col style="width: 50%">
        </colgroup>
        <tr>
            {{--<td colspan="2">Augstskola, fakultāte, studiju gadi - gggg-gggg, iegūtais grāds – pilnais tituls latviski,(saīsinājums)</td>--}}
            <td colspan="6">
                <hr>
                @foreach($user->studies as $study)
                    <div>
                        {{$study->program}}, {{$study->name}}, {{$study->faculty}},
                        studiju laiks - {{$study->start_date()}} - {{$study->end_date()}},
                        Iegūtais grāds - {{$study->degree}}
                    </div>
                @endforeach
                    <hr>
                @foreach($user->workplaces as $workplace)
                    <div>
                        {{$workplace->field}}, {{$workplace->company}}, {{$workplace->position}},
                        darba intervāls - {{$workplace->start_date()}} - {{$workplace->end_date()}},
                    </div>
                @endforeach
                <hr>
            </td>
        </tr>
        <tr>
            {{--<td>Semestris gggg I, ieņemtais amats<br></td>--}}
            {{--<td>Semestris gggg I, ieņemtais amats</td>--}}
            <?php $statuses = $user->statuses() ?>

                <td colspan="6">
                    <div>
                        @foreach($statuses as $status)
                            <div>
                                Semestris {{$status['year']}} {{$status['semester']}}, {{$status['abbreviation']}}
                            </div>
                        @endforeach
                    </div>

                </td>

        </tr>
        <tr>
            <td colspan="2">Referāts - nosaukums<br></td>
        </tr>
        <tr>
            <td colspan="2">

            </td>
        </tr>
        <tr>
            <td colspan="2">
                Tēvs - {{$user->bio->father}} <br>
                Māte - {{$user->bio->mother}} <br>
                <?php $children = (array) json_decode($user->bio->children)?>
                @if(count($children) > 0 && $children[0] != '')
                    Pēcteči:<br>
                    <ul>
                        @foreach((array)$children as $child)
                            <li>{{$child}}</li>
                        @endforeach
                    </ul>
                @endif

                <?php $otherfam = (array) json_decode($user->bio->otherfamily)?>
                @if(count($otherfam) > 0 && $otherfam[0] != '')
                    <b>Citi:</b> <br>
                    <ul>
                        @foreach($otherfam as $fam)
                            <li>{{$fam}}</li>
                        @endforeach
                    </ul>
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <hr>
                Biogrāfija
            </td>
        </tr>
        <tr>
            <td colspan="6">
                {!!$user->bio->bio!!}
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <hr>
                Biedrziņa piezīmes
            </td>
        </tr>
        <tr>
            <td colspan="6">
                {!!$user->bio->notes!!}
            </td>
        </tr>

        <tr>
            <td colspan="2">Apbalvojumi<br></td>
        </tr>
    </table>
</body>
