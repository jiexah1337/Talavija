@extends('layouts.master')

@section('content')
    @include('shared.nav')
    <main role="main" class="ml-sm-auto col-md-10 pt-3">
        <h1>Sistēmas Pārvalde</h1>
        <div class="row">
            <div class="col-md-4">

                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <div class="pull-left">
                            Amati un atļaujas
                        </div>
                        <div class="pull-right">
                            <a href="#" data-editable-type="/admin/roles" data-editable="" data-target-box="roleBox"
                               class="float-left admin-edit-btn text-warning" id="roles-list-btn" data-toggle="tooltip" title="Rediģēt">
                                <i class="fas fa-pen-square"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body" id="roleBox">

                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <div class="pull-left">
                            Statusi
                        </div>
                        <div class="pull-right">
                            <a href="#" data-editable-type="/admin/statuses" data-editable="" data-target-box="statusBox"
                               class="float-left admin-edit-btn text-warning" id="status-list-btn" data-toggle="tooltip" title="Rediģēt">
                                <i class="fas fa-pen-square"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body" id="statusBox">

                    </div>
                </div>


            </div>
            <div class="col-md-8" id="editorArea">

            </div>
        </div>
        <div id="modalBox">

        </div>
    </main>

    <script type="text/javascript">
        $(document).ready(function(){
            var editorArea = $("#editorArea");
            editorArea.slideUp();
            $(function () {
                $(".admin-edit-btn").each(function(index){
                    var targetData = $(this).attr('data-target-box');
                    var target = $("#"+targetData);
                    var baseUrl = $(this).attr('data-editable-type');

                    $.ajax({
                        type: 'GET',
                        url: baseUrl,
                        success: function (data) {
                            target.html(data.html);
                        }
                    });

                    $(this).on('click', function (e) {
                        e.preventDefault();
                        $.ajax({
                            type: 'GET',
                            url: baseUrl+'/edit',
                            success: function (data) {
                                editorArea.html(data.html);
                                editorArea.slideDown();
                            }
                        })
                    })
                });
            });
        });
    </script>

@endsection