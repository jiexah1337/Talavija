
@extends('layouts.master')

@section('content')
    @include('shared.nav')
    <head>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
    </head>
    <main role="main" class="ml-sm-auto col-md-10 pt-3">
        <br>
        <form  action="{{route('add.store')}}" method="POST" role="form">
            {{ csrf_field() }}
            <legend>
                Maksajums
            </legend>
            <div class="col-sm-6">

                <div class="form-group">
                    <label for="title">
                        Nosaukums
                    </label>
                    <input class="form-control" name="title" placeholder="Title" type="text" required="required">
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
                    <input class="form-control" name="Value" placeholder="€" type="text" required="required">
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
                    <input class="form-control" name="for_groups" placeholder="z!, fil!, com!, fil!b!, b!fil!" required="required" type="text">

                </div>

                <button class="btn btn-primary" type="submit" href="/edit">
                    Submit
                </button>

            </div>
            <br>

        </form >
    </main>


@endsection