
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
     <body>
        <form action="{{route('cal.store')}}" method="POST" role="form">
            {{csrf_field()}}
            <legend>
                Create Event
            </legend>
            <div class="col-sm-6">

            <div class="form-group">
                <label for="title">
                    Title
                </label>
                <input class="form-control" name="title" placeholder="Title" type="text" required="required">
            </div>
            <div class="form-group">
                <label for="description">
                    Description
                </label>
                <input class="form-control" name="description" placeholder="Description" required="required" type="text">
            </div>
                        <div class="form-group">
                                <label for="start_date">
                                    Pasakums saksies
                                </label>
                            <div class="input-group date" id="datetimepicker7" data-target-input="nearest">

                            <input type="text" name="start_date" class="form-control datetimepicker-input" data-target="#datetimepicker7"/>
                                <div class="input-group-append" data-target="#datetimepicker7" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end_date">
                                Pasakums beigsies
                            </label>
                            <div class="input-group date" id="datetimepicker8" data-target-input="nearest">
                                <input type="text" name="end_date" class="form-control datetimepicker-input" data-target="#datetimepicker8"/>
                                <div class="input-group-append" data-target="#datetimepicker8" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                <script type="text/javascript">
                    $(function () {

                        $('#datetimepicker7').datetimepicker({
                            format:'YYYY-MM-DDThh:mm:ss',
                        });
                        $('#datetimepicker8').datetimepicker({
                            format:'YYYY-MM-DDThh:mm:ss',
                            useCurrent: false
                        });
                        $("#datetimepicker7").on("change.datetimepicker", function (e) {
                            $('#datetimepicker8').datetimepicker('minDate', e.date);
                        });
                        $("#datetimepicker8").on("change.datetimepicker", function (e) {
                            $('#datetimepicker7').datetimepicker('maxDate', e.date);
                        });

                    });
                </script>
                <div class="form-group">
                    <label for="for_groups">
                        Prieks
                    </label>
                    <input class="form-control" name="for_groups" placeholder="z!, fil!, com!, fil!b!, b!fil!" required="required" type="text">

                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="event_important">
                    <label class="form-check-label" for="event_important">
                         Obligats
                        <br><br/>
                    </label>
                </div>
                <button class="btn btn-primary" type="submit">
                    Submit
                </button>

            </div>




        </form>
        </body>
    </main>
@endsection