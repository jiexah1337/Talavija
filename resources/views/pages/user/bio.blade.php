@extends('layouts.master')
@section('content')
    @include('shared.nav')

    <main role="main" class="ml-sm-auto col-md-10 pt-3 @if($isDead == true) dead @endif">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.standalone.min.css"/>

        <div class="">
            <h1>
                @if($canUpdateStatus)
                <a href="#" class="edit-btn" id="statusBtn" style="font-size: 2.5rem" data-editable-type="admin/statuses" data-editable="{{$bio->member_id}}">
                    {{$user->status()->abbreviation or '_!'}}
                </a>
                @else
                    {{$user->status()->abbreviation or '_!'}}
                @endif
                <strong>{{$user->name}}</strong> {{$user->surname}}
                <a href="/bio/generate-pdf/{{$user->member_id}}" target="_blank" class="text-primary" data-toggle="tooltip" title="Lejupielādēt biedra biogrāfiju (.PDF)">
                    <i class="fas fa-file-pdf"></i>
                </a>
            </h1>
        </div>

        <div>
            <div class="row">
                <!--User Image-->
                <div class="col-md-2 d-none d-sm-block" id="ProfilePictureArea">
                    @include('fragments.user-widget-small',compact(['canUpdate' => $canUpdate]))
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">

                            <div class="pull-left">
                                Pamatinformācija
                            </div>

                            <div class="pull-right">
                            <?php
                            $curUser = Sentinel::getUser();
                            if($canUpdate):?>
                                <a href="#" data-editable-type="bio/base" data-editable="{{$bio->member_id}}"
                                   class="float-left edit-btn text-warning" data-toggle="tooltip" title="Rediģēt">
                                    <i class="fas fa-pen-square"></i>
                                </a>
                            <?php endif ?>
                            </div>

                        </div>

                        <div class="card-body" id="bioBaseArea">
                            @include('fragments.bio-base', array('user' => $user, 'bio' => $bio, 'canUpdate' => $canUpdate))
                        </div>

                    </div>


                </div>
                <div class="col-md-2 col-sm-4">
                    <!-- Red Herring -->
                    <div class="card">
                        <div class="card-header">
                            <div class="pull-left">
                                Amati
                            </div>

                            <div class="pull-right">
                                <?php if($canUpdateRoles):?>
                                <a href="#" data-editable-type="bio/roles" data-editable="{{$bio->member_id}}"
                                   class="float-left edit-btn text-warning" data-toggle="tooltip" title="Rediģēt">
                                    <i class="fas fa-pen-square"></i>
                                </a>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="card-body" id="userRoleArea">
                            @include('fragments.bio-roles', array('user' => $user))
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-md-4 column-border">
                    <div class="text-center">
                        <h5>Darba Vietas
                            <?php if($canUpdate):?>
                            <a href="#" id="addWorkplace" data-memberid="{{$user->member_id}}" data-toggle="tooltip" title="Pievienot">
                                <i class="fas fa-plus-square"></i>
                            </a>
                            <?php endif ?>
                        </h5>
                    </div>
                    <div id="workplaceList" class="box-list">
                        @include('fragments.workplace-list', array('workplaces' => $workplaces, 'canUpdate' => $canUpdate))
                    </div>
                </div>
                <div class="col-md-4 column-border">
                    <div class="text-center">
                        <h5>Studēšana
                            <?php if($canUpdate):?>
                            <a href="#" id="addStudy" data-memberid="{{$user->member_id}}" data-toggle="tooltip" title="Pievienot">
                                <i class="fas fa-plus-square"></i>
                            </a>
                            <?php endif ?>
                        </h5>
                    </div>
                    <div id="studyList" class="box-list">
                        @include('fragments.study-list', array('studies' => $studies, 'canUpdate' => $canUpdate))
                    </div>
                </div>
                <div class="col-md-4 column-border">
                    <div class="text-center">
                        <h5>Dzīves vietas
                            <?php if($canUpdate):?>
                            <a href="#" id="addResidence" data-memberid="{{$user->member_id}}" data-toggle="tooltip" title="Pievienot">
                                <i class="fas fa-plus-square"></i>
                            </a>
                            <?php endif ?>
                        </h5>
                    </div>
                    <div id="residenceList" class="box-list">
                        @include('fragments.residence-list', array('residences' => $residences, 'canUpdate' => $canUpdate))
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">

                            <div>
                                <span class="float-left">
                                    Biogrāfija
                                </span>

                                <?php if($canUpdate):?>

                                <a href="#" data-editable-type="bio/biography" data-editable="{{$bio->member_id}}"
                                   class="edit-btn float-right text-warning" data-toggle="tooltip" title="Rediģēt Biogrāfiju">
                                    <i class="fas fa-pen-square"></i>
                                </a>

                                <a href="#" data-editable-type="bio/family" data-editable="{{$bio->member_id}}"
                                   class="edit-btn float-right text-warning" data-toggle="tooltip" title="Rediģēt Ģimeni">
                                    <i class="fas fa-users"></i>
                                </a>


                                <?php endif ?>
                            </div>
                        </div>



                        <div class="card-body" >
                            <div id="bioFamilyArea">
                                @include('fragments.bio-family', compact($bio, $children, $otherfam))
                            </div>

                            <hr>

                            <div id="bioArea">
                                {!! $bio->bio or '' !!}
                            </div>

                        </div>
                    </div>




                    <div class="card">
                        <div class="card-header">

                            <div>
                                <span class="float-left">
                                    Biedrziņa piezīmes
                                </span>
                                <?php if($bzUpdate):?>
                                    <a href="#" data-editable-type="bio/notes" data-editable="{{$bio->member_id}}"
                                       class="edit-btn float-right text-warning" data-toggle="tooltip" title="Rediģēt">
                                        <i class="fas fa-pen-square"></i>
                                    </a>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="card-body" id="notesArea">
                            {!! $bio->notes or '' !!}
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>



    <!--  MODALS  -->
    <div id="modalContainer">

    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            addResidence    =   $("#addResidence");
            addWorkplace    =   $("#addWorkplace");
            addStudy        =   $("#addStudy");

            editButtonOverride();
            deleteButtonOverride();

            addResidence.on("click", function(e){
                e.preventDefault();
                $.ajax({
                    type: 'GET',
                    url: '/residence/add/'+$(this).data('memberid'),
                    success: function(data){
                        $('#modalContainer').html(data.html);
                    }
                });
            });
            addWorkplace.on("click", function(e){
                e.preventDefault();
                $.ajax({
                    type: 'GET',
                    url: '/workplace/add/'+$(this).data('memberid'),
                    success: function(data){
                        $('#modalContainer').html(data.html);
                    }
                });
            });
            addStudy.on("click", function(e){
                e.preventDefault();
                $.ajax({
                    type: 'GET',
                    url: '/study/add/'+$(this).data('memberid'),
                    success: function(data){
                        $('#modalContainer').html(data.html);
                    }
                });
            });
        })
    </script>
@endsection