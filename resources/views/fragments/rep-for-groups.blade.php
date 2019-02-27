@extends('layouts.master')
@section('content')

    @include('shared.nav')
    <head>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
    </head>
    <main role="main" class="ml-sm-auto col-md-9 pt-3">
        <br>
        <div class="row">
            <form  action="{{route('add.store')}}" method="POST" role="form">
                {{ csrf_field() }}
                <div class="col md-8">

                    <div class="form-group">
                        <label for="title">
                            Maksajuma tips
                        </label>
                        <select class="form-control" id="rep-type" name="title">
                            <option > </option>
                            <option >Maksājums</option>
                            <option >Sods</option>
                            <option >Prēmija</option>
                            <option >Cits</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="start_date">
                            Pierakstisanas datums
                        </label>
                        <div class="input-group date" id="datetimepicker" data-target-input="nearest">

                            <input type="text" name="start_date" class="form-control datetimepicker-input" data-target="#datetimepicker"/>
                            <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Value">
                            Summa
                        </label>
                        <input class="form-control" name="Value" id="value" placeholder="€" type="text" required="required">
                    </div>
                    <div class="form-group">
                        <label for="Reason">
                            Merkis
                        </label>
                        <input class="form-control" name="Reason" placeholder="Ikmenesa maksajums/Sods" type="text" required="required">
                    </div>

                    <script type="text/javascript">

                        $('#datetimepicker').datetimepicker({
                            format:'YYYY-MM-DD ',
                        });

                    </script>

                    <div class="form-group">
                        <label for="for_groups">
                            Prieks
                        </label>
                        <input class="form-control" name="for_groups" placeholder="z!, fil!, com!, fil!b!, b!fil!" onchange="selectusers(this)" type="text">
                    </div>
                    @foreach($statuses as $status)
                        <input type="checkbox" name="status[]" value="{{$status->id}}"> {{$status->title}}<br>
                    @endforeach
                </div>

                <legend>
                    Maksajums
                </legend>
                <br>
                <div id="tablediv" >
                    <table class="table table-striped table-hover table-sm text-center" id="users" >
                        <thead class="thead-dark" >
                        <tr>
                            <th>Biedra_numurs</th>
                            <th>Vārds</th>
                            <th>Uzvārds</th>
                        </tr>
                        </thead>
                        <tr id="row_[]">
                        </tr>
                    </table>
                </div>
                <input type="hidden" id="savereps" name="savereps" value=""/>
                <script>

                    function selectusers(inputobject){
                        groups=inputobject.value;
                        value=document.getElementById("value").value;
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: '/money/RepForGroups/fillTable',
                            data: { "Members": groups,"Value": value },
                            success: function (data){
                                document.getElementById("savereps").value=JSON.stringify(data);
                                maketable (data);
                            },
                            error: function (req, status, error){
                                console.log(req);
                            }
                        });

                    }
                    function maketable(data) {
                        document.getElementById("tablediv").style.display='table';
                        var table = document.getElementById("users");

                        var rowCount = table.rows.length;
                        for (var i = 1; i < rowCount; i++) {
                            table.deleteRow(1);
                        }


                        for (i = 0; i < data.length; i++) {
                            row= table.insertRow(1);
                            cell1 = row.insertCell(0);
                            cell1.innerHTML = data[i]['lastname'];
                            cell1 = row.insertCell(0);
                            cell1.innerHTML = data[i]['name'];
                            cell1 = row.insertCell(0);
                            member_id=data[i]['member_id'];
                            cell1.innerHTML = '<a href="/bio/'+member_id+'">'+member_id+'</a>';
                        {{--<a target="_blank" href="/bio/{{$user->member_id}}">--}}
                                    {{--{{$user->member_id}}--}}
                                {{--</a>--}}



                        }

                    }
                </script>



                <button class="btn btn-primary" type="submit" href="/edit">
                    Submit
                </button>


                <br>
            </form >

            <div class="col md-4">
                @include('fragments.samaksat')
            </div>
        </div>
    </main>


@endsection
