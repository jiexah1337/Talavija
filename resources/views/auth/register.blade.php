@extends('layouts.master')

@section('content')
    @include('shared.nav')
    <main role="main" class="ml-sm-auto col-md-10 pt-3">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.standalone.min.css"/>
        <div class="panel panel-default">
            <div class="panel-heading"><h1>Reģistrēt jaunu biedru</h1></div>

            <div class="panel-body">

                <form method="POST" action="/users/register">
                    @include('shared.validation-errors')
                    {{csrf_field()}}
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            Pamatinformācija
                        </div>

                        <div class="card-body">
                            <div class="form-group row">
                                <label for="number" class="col-sm-2 col-form-label required">Biedra numurs</label>
                                <div class="col-sm-4">
                                    <input type="number" required class="form-control" id="number" name="member_id"
                                           value="{{old('member_id')}}" data-toggle="popover" data-placement="top" placeholder="#">
                                </div>
                                @if(Sentinel::getUser()->hasAccess('statuses.attach'))
                                <label for="status" class="col-sm-2 col-form-label">Statuss</label>
                                <div class="col-sm-4">
                                    <select name="status" class="form-control" id="status">
                                        @foreach($statuses as $status)
                                            <option value="{{$status->id}}">{{$status->title}} {{$status->abbreviation}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label required">Vārds</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="name" name="name" value="{{old('name')}}" data-toggle="popover" data-placement="top" placeholder="Vārds">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="surname" class="col-sm-2 col-form-label required">Uzvārds</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="surname" name="surname" value="{{old('surname')}}" data-toggle="popover" data-placement="top" placeholder="Uzvārds">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label required">E-Pasts</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" data-toggle="popover" data-placement="top"
                                           value="{{old('email')}}" placeholder="vārds.usvārds.nr@talavija-nomail.lv">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-sm-2 col-form-label">Telefona Numurs</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="+000 00000000" data-toggle="popover" data-placement="top"
                                           value="{{old('phone')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            Dzimšanas informācija
                        </div>

                        <div class="card-body">
                            <div class="form-group row date">
                                <label for="birth_date" class="col-sm-2 col-form-label required">Dzimšanas datums</label>
                                <div class="col-sm-3">
                                    <input type="number" min="1" max="31" required class="form-control" id="birth_day" name="birth_day" value="{{old('birth_day')}}" placeholder="DD">
                                </div>
                                <div class="col-sm-3">
                                    {{--<input type="number" min="1" max="12" requzired class="form-control" id="birth_month" name="birth_month" value="{{old('birth_month')}}" placeholder="MM">--}}
                                    <select name="birth_month" class="form-control" id="birth_month">
                                        <option value="1">Janvāris</option>
                                        <option value="2">Februāris</option>
                                        <option value="3">Marts</option>
                                        <option value="4">Aprīlis</option>
                                        <option value="5">Maijs</option>
                                        <option value="6">Jūnijs</option>
                                        <option value="7">Jūlijs</option>
                                        <option value="8">Augusts</option>
                                        <option value="9">Septembris</option>
                                        <option value="10">Oktobris</option>
                                        <option value="11">Novembris</option>
                                        <option value="12">Decembris</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="number" min="1" required class="form-control" id="birth_year" name="birth_year" value="{{old('birth_year')}}" placeholder="GGGG">
                                </div>


            

                                <script>
                                    $(document).ready(function(){
                                        // validateDate($("#birth_day"),$("#birth_month"),$("#birth_year"));
                                    })
                                </script>

                            </div>

                            <div class="form-group row">
                                <label for="b_country" class="col-sm-2 col-form-label">Valsts</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="b_country" name="b_country" value="{{old('b_country')}}" placeholder="Valsts">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="b_city" class="col-sm-2 col-form-label">Pilsēta</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="b_city" name="b_city" value="{{old('b_city')}}" placeholder="Pilsēta">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="b_country" class="col-sm-2 col-form-label">Adrese</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="b_address" name="b_address" value="{{old('b_address')}}" placeholder="Adrese">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="b_other" class="col-sm-2 col-form-label">Piezīmes</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="b_other" name="b_other" value="{{old('b_other')}}" placeholder="Piezīmes">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            Nāves informācija
                        </div>

                        <div class="card-body">
                            <div class="form-group row date">
                                <label for="deceased_date" class="col-sm-2 col-form-label">Nāves datums</label>
                                <div class="col-sm-3">
                                    <input type="number" min="1" max="31" class="form-control" id="deceased_day" name="deceased_day" value="{{old('deceased_day')}}" placeholder="DD">
                                </div>
                                <div class="col-sm-3">
                                    <select name="deceased_month" class="form-control" id="deceased_month">
                                        <option value="1">Janvāris</option>
                                        <option value="2">Februāris</option>
                                        <option value="3">Marts</option>
                                        <option value="4">Aprīlis</option>
                                        <option value="5">Maijs</option>
                                        <option value="6">Jūnijs</option>
                                        <option value="7">Jūlijs</option>
                                        <option value="8">Augusts</option>
                                        <option value="9">Septembris</option>
                                        <option value="10">Oktobris</option>
                                        <option value="11">Novembris</option>
                                        <option value="12">Decembris</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="number" min="1" class="form-control" id="deceased_year" name="deceased_year" value="{{old('deceased_year')}}" placeholder="GGGG">
                                </div>

                                <script>
                                    $(document).ready(function(){
                                        // validateDate($("#deceased_day"),$("#deceased_month"),$("#deceased_year"));
                                    })
                                </script>
                            </div>

                            <div class="form-group row">
                                <label for="d_country" class="col-sm-2 col-form-label">Valsts</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="d_country" name="d_country" value="{{old('d_country')}}" placeholder="Valsts">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="d_city" class="col-sm-2 col-form-label">Pilsēta</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="d_city" name="d_city" value="{{old('d_city')}}" placeholder="Pilsēta">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="d_address" class="col-sm-2 col-form-label">Adrese</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="d_address" name="d_address" value="{{old('d_address')}}" placeholder="Adrese">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="d_other" class="col-sm-2 col-form-label">Piezīmes</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="d_other" name="d_other" value="{{old('d_other')}}" placeholder="Piezīmes">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            Vēsture korporācijā
                        </div>

                        <div class="card-body">
                            <div class="form-group row">
                                <label for="start_date" class="col-sm-2 col-form-label">Uzņemts V!K! </label>
                                <div class="col-sm-3">
                                    <input type="number" min="1" max="31" class="form-control" id="start_day" name="start_day" value="{{old('start_day')}}" placeholder="DD">
                                </div>
                                <div class="col-sm-3">
                                    {{--<input type="number" min="1" max="12" required class="form-control" id="birth_month" name="birth_month" value="{{old('birth_month')}}" placeholder="MM">--}}
                                    <select name="start_month" class="form-control" id="start_month">
                                        <option value="1">Janvāris</option>
                                        <option value="2">Februāris</option>
                                        <option value="3">Marts</option>
                                        <option value="4">Aprīlis</option>
                                        <option value="5">Maijs</option>
                                        <option value="6">Jūnijs</option>
                                        <option value="7">Jūlijs</option>
                                        <option value="8">Augusts</option>
                                        <option value="9">Septembris</option>
                                        <option value="10">Oktobris</option>
                                        <option value="11">Novembris</option>
                                        <option value="12">Decembris</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="number" min="1" class="form-control" id="start_year" name="start_year" value="{{old('start_year')}}" placeholder="GGGG">
                                </div>

                                <button type="button" id="set_today_start_date" class="btn btn-primary">Šodiena</button>

                                <script>
                                    $(document).ready(function(){
                                        validateDate($("#start_day"),$("#start_month"),$("#start_year"));
                                        $("#set_today_start_date").on('click', function(){
                                            var d = new Date();

                                            var month = d.getMonth()+1;
                                            var day = d.getDate();
                                            var year = d.getFullYear();

                                            $("#start_day").val(day);
                                            $("#start_month").val(month);
                                            $("#start_year").val(year);
                                        })
                                    })
                                </script>
                            </div>

                            <div class="form-group row">
                                <label for="spk_date" class="col-sm-2 col-form-label">Uzņemts Sp!K! </label>
                                <div class="col-sm-3">
                                    <input type="number" min="1" max="31" class="form-control" id="spk_day" name="spk_day" value="{{old('spk_day')}}" placeholder="DD">
                                </div>
                                <div class="col-sm-3">
                                    {{--<input type="number" min="1" max="12" required class="form-control" id="birth_month" name="birth_month" value="{{old('birth_month')}}" placeholder="MM">--}}
                                    <select name="spk_month" class="form-control" id="spk_month">
                                        <option value="1">Janvāris</option>
                                        <option value="2">Februāris</option>
                                        <option value="3">Marts</option>
                                        <option value="4">Aprīlis</option>
                                        <option value="5">Maijs</option>
                                        <option value="6">Jūnijs</option>
                                        <option value="7">Jūlijs</option>
                                        <option value="8">Augusts</option>
                                        <option value="9">Septembris</option>
                                        <option value="10">Oktobris</option>
                                        <option value="11">Novembris</option>
                                        <option value="12">Decembris</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="number" min="1" class="form-control" id="spk_year" name="spk_year" value="{{old('spk_year')}}" placeholder="GGGG">
                                </div>

                                <button type="button" id="set_today_spk_date" class="btn btn-primary">Šodiena</button>

                                <script>
                                    $(document).ready(function(){
                                        validateDate($("#spk_day"),$("#spk_month"),$("#spk_year"));
                                        $("#set_today_spk_date").on('click', function(){
                                            var d = new Date();

                                            var month = d.getMonth()+1;
                                            var day = d.getDate();
                                            var year = d.getFullYear();

                                            $("#spk_day").val(day);
                                            $("#spk_month").val(month);
                                            $("#spk_year").val(year);
                                        })
                                    })
                                </script>
                            </div>

                            <div class="form-group row">
                                <label for="fil_date" class="col-sm-2 col-form-label">Filistrējies </label>
                                <div class="col-sm-3">
                                    <input type="number" min="1" max="31" class="form-control" id="fil_day" name="fil_day" value="{{old('fil_day')}}" placeholder="DD">
                                </div>
                                <div class="col-sm-3">
                                    {{--<input type="number" min="1" max="12" required class="form-control" id="birth_month" name="birth_month" value="{{old('birth_month')}}" placeholder="MM">--}}
                                    <select name="fil_month" class="form-control" id="fil_month">
                                        <option value="1">Janvāris</option>
                                        <option value="2">Februāris</option>
                                        <option value="3">Marts</option>
                                        <option value="4">Aprīlis</option>
                                        <option value="5">Maijs</option>
                                        <option value="6">Jūnijs</option>
                                        <option value="7">Jūlijs</option>
                                        <option value="8">Augusts</option>
                                        <option value="9">Septembris</option>
                                        <option value="10">Oktobris</option>
                                        <option value="11">Novembris</option>
                                        <option value="12">Decembris</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="number" min="1" class="form-control" id="fil_year" name="fil_year" value="{{old('fil_year')}}" placeholder="GGGG">
                                </div>

                                <button type="button" id="set_today_fil_date" class="btn btn-primary">Šodiena</button>

                                <script>
                                    $(document).ready(function(){
                                        validateDate($("#fil_day"),$("#fil_month"),$("#fil_year"));
                                        $("#set_today_fil_date").on('click', function(){
                                            var d = new Date();

                                            var month = d.getMonth()+1;
                                            var day = d.getDate();
                                            var year = d.getFullYear();

                                            $("#fil_day").val(day);
                                            $("#fil_month").val(month);
                                            $("#fil_year").val(year);
                                        })
                                    })
                                </script>
                            </div>
                        </div>
                    </div>




                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            Old!, K!tēvs, K!māte
                        </div>
                        <div class="card-body">

                            <div class="form-group row">
                                <label for="olderman_input" class="col-sm-2 col-form-label">Oldermanis</label>
                                <div class="col-sm-5">
                                    <input type="text" placeholder="Vārds Uzvārds (Biedra Numurs)" class="form-control" data-actual-id="" id="olderman_input" name="olderman_input" value="{{old('olderman_input')}}">
                                    <div>
                                        <div class="list-group text-dark" id="oldermanList">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div id="olderman_fields" style="display: none">
                                        <div class="form-group row">
                                            <div class="col-sm-4">
                                                <input class="form-control" placeholder="Vārds"
                                                       id="olderman_name" name="olderman_name">
                                            </div>
                                            <div class="col-sm-4">
                                                <input class="form-control" placeholder="Uzvārds"
                                                       id="olderman_surname" name="olderman_surname">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="number" class="form-control" placeholder="Biedra numurs"
                                                       id="olderman_mId" name="olderman_mId" data-toggle="popover" data-title="" data-placement="top">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="olderman_labels">
                                        <div class="row">

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="col_father_input" class="col-sm-2 col-form-label">Krāsu tēvs</label>
                                <div class="col-sm-5">
                                    <input type="text" placeholder="Vārds Uzvārds (Biedra Numurs)" class="form-control" id="col_father_input" name="col_father_input" value="{{old('col_father_input')}}">
                                    <div>
                                        <div class="list-group text-dark" id="colfatherList">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div id="col_father_fields" style="display: none">
                                        <div class="form-group row">
                                            <div class="col-sm-4">
                                                <input class="form-control" placeholder="Vārds"
                                                       id="col_father_name" name="col_father_name">
                                            </div>
                                            <div class="col-sm-4">
                                                <input class="form-control" placeholder="Uzvārds"
                                                       id="col_father_surname" name="col_father_surname">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="number" class="form-control" placeholder="Biedra numurs"
                                                       id="col_father_mId" name="col_father_mId" data-toggle="popover" data-title="" data-placement="top">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="colfather_labels">
                                        <div class="row">

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="col_mother_input" class="col-sm-2 col-form-label">Krāsu māte</label>
                                <div class="col-sm-5">
                                    <input type="text" placeholder="Vārds Uzvārds (Biedra Numurs)" class="form-control" id="col_mother_input" name="col_mother_input" value="{{old('col_mother_input')}}">
                                    <div>
                                        <div class="list-group text-dark" id="colmotherList">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div id="col_mother_fields" style="display: none">
                                        <div class="form-group row">
                                            <div class="col-sm-4">
                                                <input class="form-control" placeholder="Vārds"
                                                       id="col_mother_name" name="col_mother_name">
                                            </div>
                                            <div class="col-sm-4">
                                                <input class="form-control" placeholder="Uzvārds"
                                                       id="col_mother_surname" name="col_mother_surname">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="number" class="form-control" placeholder="Biedra numurs"
                                                       id="col_mother_mId" name="col_mother_mId" data-toggle="popover" data-title="" data-placement="top">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="colmother_labels">
                                        <div class="row">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Reģistrēt</button>
                        </div>
                    </div>
                </form>
                <script type="text/javascript">
                    $(document).ready( function(){
                        var timeout = null;

                        var member_id_field = $("#number");
                        var phone_field = $("#phone");
                        var email_field = $("#email");
                        var name_field = $("#name");
                        var surname_field = $("#surname");

                        emailTrick([$("#name"),$("#surname"), member_id_field], '@talavija-nomail.lv', email_field);
                        validateDates([$("#birth_day"),$("#birth_month"),$("#birth_year")],[$("#deceased_day"),$("#deceased_month"),$("#deceased_year")]);

                        member_id_field.on('change input keyup', function(e) {
                            clearTimeout(timeout);
                            timeout = setTimeout(function () {
                                validate('mId',member_id_field.val(),member_id_field, true);
                            }, 500);
                        });

                        phone_field.on('change input keyup', function(e) {
                            clearTimeout(timeout);
                            timeout = setTimeout(function () {
                                validate('phone',phone_field.val(),phone_field, true);
                            }, 500);
                        });

                        email_field.on('change input keyup', function(e) {
                            clearTimeout(timeout);
                            timeout = setTimeout(function () {
                                validate('email',email_field.val(),email_field, true);
                            }, 500);
                        });

                        name_field.on('change input keyup', function(e) {
                            clearTimeout(timeout);
                            timeout = setTimeout(function () {
                                validate('name',name_field.val(),name_field, true);
                            }, 500);
                        });

                        surname_field.on('change input keyup', function(e) {
                            clearTimeout(timeout);
                            timeout = setTimeout(function () {
                                validate('surname',surname_field.val(),surname_field, true);
                            }, 500);
                        });

                        var colm = $("#col_mother_mId");
                        var colf = $("#col_father_mId");
                        var oldm = $("#olderman_mId");

                        function duplicateIdCheck(testableField){
                            if(testableField.val() == member_id_field.val() && testableField.val() != ''){
                                popper(testableField, 'Biedra nummurs izmantots jaunā biedra reģistrācijā', 'show');
                            } else {
                                popper(testableField, '-', 'hide');
                            }
                        }

                        colm.on('change input keyup', duplicateIdCheck(colm));
                        colf.on('change input keyup', duplicateIdCheck(colf));
                        oldm.on('change input keyup', duplicateIdCheck(oldm));

                        userSearchDropdown($('#col_mother_input'), $('#colmotherList'), 'colmother-dd-item', 'col_mother');
                        userSearchDropdown($('#col_father_input'), $('#colfatherList'), 'colfather-dd-item', 'col_father');
                        userSearchDropdown($('#olderman_input'), $('#oldermanList'), 'olderman-dd-item', 'olderman');
                    });

                </script>

            </div>
        </div>
    </main>

@endsection
