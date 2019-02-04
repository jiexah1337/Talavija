@extends('layouts.master')

@section('content')
    @include('shared.nav')
    <main role="main" class="ml-sm-auto col-md-10 pt-3">
        <div class="card">
            <div class="card-header text-center bg-dark text-light">
                <b>
                    <a target="_blank" href="/bio/{{$user->member_id}}">
                        {{$user->member_id}}
                    </a>
                    {{$user->name.' '.$user->surname}}</b> - Repartīcijas par: {{$year}}, {{$monthName}}
                    <a href="#" id="addRepatriation" data-year="{{$year}}" data-month="{{$month}}" data-member="{{$user->member_id}}" data-toggle="tooltip" title="Pievienot">
                        <i class="fas fa-plus-square"></i>
                    </a>
            </div>
            <div class="card-body">
                <div id="monthlyList">
                    @include('fragments.repatriation-list', $reps)
                </div>
            </div>
        </div>



    </main>

    <div id="modalContainer">

    </div>

    <script>
        var repAdd = $("#addRepatriation");
        repAdd.on("click", function(e){
            e.preventDefault();
            var year = repAdd.attr('data-year');
            var month = repAdd.attr('data-month');
            var member = repAdd.attr('data-member');

            $.ajax({
                type: 'GET',
                url: '/money/edit',
                dataType: 'json',
                data: { year : year, month : month, member : member},
                success: function(data){
                    $('#modalContainer').html(data.html);
                }
            });
        });
    </script>
@endsection