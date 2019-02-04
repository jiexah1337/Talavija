@extends('layouts.master')

@section('content')
    @include('shared.nav')
    <main role="main" class="ml-sm-auto col-md-10 pt-3">
        {{--<h1>Repartīcijas</h1>--}}
        <div class="text-center bg-dark text-light">

        </div>
        <div class="row">
            <div class="col-md-6">
                <input class="form-control mr-sm-2" id="searchBar" placeholder="Meklēšana (Atdalīt ar atstarpi)" data-pagecount="{{$pageCount}}" type="text">
            </div>

            <div class="col-md-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">

                        <li class="page-item">
                            <a class="page-link year-btn" data-increment="-1" href="#"><i class="fas fa-angle-left"></i></a>
                        </li>

                        <li class="page-item">
                            <input type="number" min="1" id="yearField" class="page-link text-center" width="50px" value="{{$year}}">
                        </li>

                        <li class="page-item">
                            <a class="page-link year-btn" data-increment="1" href="#"><i class="fas fa-angle-right"></i></a>
                        </li>

                    </ul>
                </nav>
            </div>

            <div class="col-md-3">
                <nav>
                    <ul class="pagination justify-content-center">

                        <li class="page-item">
                            <a class="page-link page-btn" data-increment="-5" href="#"><i class="fas fa-angle-double-left"></i></a>
                        </li>

                        <li class="page-item">
                            <a class="page-link page-btn" data-increment="-1" href="#"><i class="fas fa-angle-left"></i></a>
                        </li>

                        <li class="page-item">
                            <input type="number" min="1" max="{{$pageCount}}" id="pageField" class="page-link text-center" width="50px" value="{{$page}}">
                        </li>

                        <li class="page-item">
                            <a class="page-link page-btn" data-increment="1" href="#"><i class="fas fa-angle-right"></i></a>
                        </li>

                        <li class="page-item">
                            <a class="page-link page-btn" data-increment="+5" href="#"><i class="fas fa-angle-double-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="table-responsive" id="moneyTable">
            @include('fragments.money-table', array('users','reps','year','page','pageCount'))
        </div>
        <div id="modalContainer">

        </div>

        <div id="subModalContainer">

        </div>

        <script type="text/javascript">
            $(document).ready(function(){
                var searchField = $("#searchBar");
                var pageField = $("#pageField");
                var yearField = $("#yearField");

                function search(input){
                    $.ajax({
                        type: "GET",
                        url: '/money/listsearch/'+yearField.val()+'/'+pageField.val()+'/'+input,
                        success: function(data){
                            $("#moneyTable").html(data.html);
                        }
                    })
                }

                function dataLoader(){
                    $.ajax({
                        type: "GET",
                        url: '/money/' + pageField.val() + '/' + yearField.val() + '/async',
                        success: function(data){
                            $("#moneyTable").html(data.html);
                        }
                    });
                    pageButtonOverride();
                };

                var timeout_page = null;
                var timeout_year = null;
                var timeout_search = null;

                var pageCount = parseInt(searchField.attr('data-pagecount'));

                searchField.on('change textInput input', function(){
                    clearTimeout(timeout_search);
                    timeout_search = setTimeout(function(){
                        search(searchField.val());
                    }, 500);
                });

                pageField.on('change', function(){
                    clearTimeout(timeout_page);
                    timeout_page = setTimeout(function(){
                        dataLoader();
                        // $(location).attr('href','/money/' + pageField.val() + '/' + yearField.val());
                    }, 500);

                });

                yearField.on('change', function(){
                    clearTimeout(timeout_year);
                    timeout_year = setTimeout(function(){
                        dataLoader();
                        // $(location).attr('href','/money/' + pageField.val() + '/' + yearField.val());
                    }, 1000);

                })

                function pageButtonOverride(){
                    var currentPage = pageField.val();
                    var currentYear = yearField.val();
                    $('.page-btn').each(function(index){
                        var x = parseInt(currentPage) + parseInt($(this).attr('data-increment'));
                        if(x < 1 || x > pageCount){
                            $(this).parent().addClass("disabled");
                        } else {
                            $(this).parent().removeClass("disabled");
                        }

                        $(this).unbind("click");
                        $(this).on("click", function(e){
                            e.preventDefault();
                            pageField.val(x);
                            pageField.change();
                        });
                    });
                    $('.year-btn').each(function(index){
                        var x = parseInt(currentYear) + parseInt($(this).attr('data-increment'));
                        if(x < 1 ){
                            $(this).parent().addClass("disabled");
                        } else {
                            $(this).parent().removeClass("disabled");
                        }

                        $(this).unbind("click");
                        $(this).on("click", function(e){
                            e.preventDefault();
                            yearField.val(x);
                            yearField.change();
                        });
                    });
                }

                pageButtonOverride();
            });


        </script>
    </main>
@endsection