<table class="table table-striped table-hover table-sm text-center">
    <thead class="thead-dark">
    <tr>
        <th data-toggle="tooltip" data-placement="bottom" title="Biedra Nr.">#</th>
        <th>Vārds</th>
        <th>Uzvārds</th>
        <th>Statuss</th>
        <th>Bilance</th>
        <th>I</th>
        <th>II</th>
        <th>III</th>
        <th>IV</th>
        <th>V</th>
        <th>VI</th>
        <th>VII</th>
        <th>VIII</th>
        <th>IX</th>
        <th>X</th>
        <th>XI</th>
        <th>XII</th>
        <th>Gada Summa</th>
        <th>Sodi</th>
        <th>Saņemts</th>
        <th>Gada Bilance</th>
    </tr>
    </thead>

    <tbody class="">
    @foreach($users as $key=>$user)
            <?php
            if(isset($reps[$user->member_id])){
                $rep = $reps[$user->member_id];
            }
            ?>
            <tr>
            <th scope="row" class="text-center">
                <a href="/bio/{{$user->member_id}}">
                    {{$user->member_id}}
                </a>
            </th>
            <td>{{$user->name}}</td>
            <td>{{$user->surname}}</td>
            <td>{{$user->status()->abbreviation }}</td>


            <!-- TODO: Yearly balance -->
            <td class="nyi">
            <!-- OKAY maybe you don't understand how it works?
            Es meginasu pastastit xD
            Ieks RepatriationController ir metods getBallance kurs skaita balanci lieotajiem par visiem gadiem
            un ari ir metords getReps(kuru rakstija Davis ttd nestastisu ka vins strada), mes padodam getBallance rezultatu uz
            getReps un tad getReps returno to uz view. u can chack what is $balance with dd($balance)
            $users[$key]->member_id mums padod membera id kuru mes tagad apstradajam un mes atspogulojam vina bilanci
            -->
                @if(isset($balance[$users[$key]->member_id]))
                    {{$balance[$users[$key]->member_id]->total_balance}}
                @endif
            </td>




            <!-- MONTH FOREACH LOOP -->
            @for($i = 1; $i <=12; $i++)
                <td class="text-center">
                    <?php
                    $class = 'text-muted';
                    $string = '0.00';

                    if(isset($rep))
                    {
                        $sum = $rep->where('month', $i)->sum('amount');
                        if($sum > 0){
                            $class = 'money-style-bad';
                        } else if($sum < 0) {
                            $class = 'money-style-good';
                        }
                        $string = number_format($sum, 2, ',', ' ');
                    } else {
                        $string = number_format(0.00,2,',',' ');
                    }
                    ?>
                    <a class="{{$class}} rep-edit" data-year="{{$year}}" data-month="{{$i}}" data-member="{{$user->member_id}}" href="#">
                        {{$string}}
                    </a>
                </td>
        @endfor
        <!-- END OF MONTH FOREACH LOOP -->
            <td class="text-center">

                <!-- YEARLY SUM -->
                @if(isset($rep))
                    {{number_format($rep->sum('amount'), 2, ',', ' ')}}
                @else
                    {{number_format(0.00,2,',',' ')}}
                @endif
            </td>

            <!-- TODO: calculation of penalties, received funds and yearly balance -->
            <td class="text-center">

                <!-- PENALTY SUM -->
                @if(isset($rep))
                    {{number_format($rep->where('type', 'Sods')->sum('amount'), 2, ',', ' ')}}
                @else
                    {{number_format(0.00,2,',',' ')}}
                @endif
            </td>
            <td class="text-center">
                @if(isset($rep))
                    {{number_format($rep->sum('collected'), 2, ',', ' ')}}
                @else
                    {{number_format(0.00,2,',',' ')}}
                @endif
            </td>
            <td class="text-center">

                @if(isset($rep))
                    {{number_format($rep->sum('collected') - $rep->sum('amount'), 2, ',', ' ')}}
                @else
                    {{number_format(0.00,2,',',' ')}}
                @endif </td>

        </tr>
        <?php $rep = null; ?>
    @endforeach
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function(){
        repatriationEditButtons();
    });
</script>