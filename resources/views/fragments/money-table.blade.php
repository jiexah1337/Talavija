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
        <th>Pagaides</th>
        <th>Saņemts</th>
        <th>Gala Bilance</th>
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
            <td class="text-center">
            <!-- OKAY maybe you don't understand how it works?
            Es meginasu pastastit xD
            Ieks RepatriationController ir metods getBallance kurs skaita balanci lieotajiem par visiem gadiem
            un ari ir metords getReps(kuru rakstija Davis ttd nestastisu ka vins strada), mes padodam getBallance rezultatu uz
            getReps un tad getReps returno to uz view. u can chack what is $balance with dd($balance)
            $users[$key]->member_id mums padod membera id kuru mes tagad apstradajam un mes atspogulojam vina bilanci
            -->

               @if(isset($balance[$users[$key]->member_id]))
                    {{number_format($balance[$users[$key]->member_id]->where('year','<',2019)->sum('amount'), 2, ',', ' ')}}
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

                    {{--<a  class="{{$class}} rep-edit" data-year="{{$year}}" data-month="{{$i}}" data-toggle = "modal" data-member="{{$user->member_id}}" data-target="#myModal" href="#">--}}
                        {{--{{$string}}--}}
                    {{--</a>--}}
                        <a class="{{$class}}" data-year="{{$year}}" data-month="{{$i}}" data-toggle = "modal" data-member="{{$user->member_id}}"  data-target="#exampleModal"  data-whatever="@mdo">{{$string}}</a>

                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">

                                        <div id="modalContainer" name="modalContainers">

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>




                        {{--<a href="/money/edit/{{$user->member_id}}/{{$year}}/{{$i}}" id="addRepatriation" data-year="{{$year}}" data-month="{{$i}}" data-member="{{$user->member_id}}" data-toggle="tooltip" title="Pievienot">--}}
                            {{--<i class="fas fa-plus-square"></i>--}}
                        {{--</a>--}}


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
                    {{number_format($rep->where('amount','<', '0')->sum('amount') *-1, 2, ',', ' ')}}
                @else
                    {{number_format(0.00,2,',',' ')}}
                @endif
            </td>
            <td class="text-center">
                @if(isset($rep))
                    {{number_format($rep->where('amount','>',0)->sum('amount'), 2, ',', ' ')}}
                @else
                    {{number_format(0.00,2,',',' ')}}
                @endif
            </td>
            <td class="text-center">

                @if(isset($rep))
                    {{number_format($rep->where('year',$year)->sum('amount'), 2, ',', ' ')}}
                @else
                    {{number_format(0.00,2,',',' ')}}
                @endif </td>

        </tr>
        <?php $rep = null; ?>
    @endforeach
    </tbody>
</table>

<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        var year = button.data('year')
        var month = button.data('month')
        var member_id = button.data('member')
        $.ajax({
            type: 'GET',
            url: '/money/listload' + '/' + member_id + '/' + year + '/' + month,
            dataType: 'json',
            data: {year: year, month: month, member: member_id},
            success: function (data) {
                $('#modalContainer').html(data.html);
                console.log(data);
            }
        });
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)

    })
</script>
<script type="text/javascript">
    $(document).ready(function(){
        repatriationEditButtons();
    });
</script>