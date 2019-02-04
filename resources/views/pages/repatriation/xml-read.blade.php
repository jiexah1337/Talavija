@extends('layouts.master')

@section('content')
    @include('shared.nav')
    <main role="main" class="ml-sm-auto col-md-10 pt-3">
        {{--<h1>Repartīcijas</h1>--}}
        <div class="text-center bg-dark text-light">

        </div>
        <div class="row">
            <form action="{{$actionURL}}" method="GET" id="xmlform">
                {{csrf_field()}}
                <div class="form-group row">
                    <input type="file" name="xml" class="form-control" id="xml">
                </div>
            </form>
        </div>

        <div id="modalContainer">

        </div>

    </main>
    <script type="application/javascript">
        $("#xml").on("change", function (e) {
            var dab = new FormData();
            dab.append('xml',$('#xml')[0].files[0]);
            $.ajax({
                url: $("#xmlform").attr('action'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: dab,
                processData: false,
                contentType: false,
                cache: false,
                success: function( data ) {
                    $('#modalContainer').html(data.html);
                },
                error: function (xhr, status, error) {

                }
            });
        })
    </script>
@endsection