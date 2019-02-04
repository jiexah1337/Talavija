@extends('layouts.master')

@section('content')
    @include('shared.nav')
    <main role="main" class="ml-sm-auto col-md-10 pt-3">
        <h1>Lietotāji</h1>
        <div class="row">
            <div class="col-md-9">
                <input class="form-control mr-sm-2" id="searchBar" data-pagecount="{{$pageCount}}" placeholder="Meklēšana (Atdalīt ar atstarpi)" type="text">
            </div>
            <div class="col-md-3">
                <nav aria-label="Page navigation example">
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
                            <a class="page-link page-btn" data-increment="5" href="#"><i class="fas fa-angle-double-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="table-responsive" id="users">

            @include('fragments.user-table', array('users' => $users))
        </div>
    </main>
    <script type="text/javascript">
        $(document).ready(function(){
            var searchField = $("#searchBar");
            var pageField = $("#pageField");
            function search(input){
                $.ajax({
                    type: "GET",
                    url: '/users/listsearch/'+pageField.val()+'/'+input,
                    success: function(data){
                        $("#users").html(data.html);
                    }
                })
            }

            var timeout_page = null;
            var timeout_search = null;

            var pageCount = parseInt(searchField.attr('data-pagecount'));

            function dataLoader(){
                $.ajax({
                    type: "GET",
                    url: '/users/list/' + pageField.val() + '/async',
                    success: function(data){
                        $("#users").html(data.html);
                    }
                });
                pageButtonOverride();
            };

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
                }, 500);

            })

            function pageButtonOverride(){
                var currentPage = pageField.val();
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
            }

            pageButtonOverride();
        });


    </script>
@endsection