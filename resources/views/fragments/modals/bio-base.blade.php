<div class="modal fade show" id="editBioBaseModal" tabindex="-1" role="dialog" aria-labelledby="editBioBaseModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Pamatinformācija</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="fade show active">
                    <div>
                        @include('shared.validation-errors')
                        <form method="POST" action="{{$actionurl}}" id="bioBaseForm" data-memberid="{{$member_id}}">
                            {{csrf_field()}}
                            <?php $currentUser = Sentinel::getUser()?>
                            <nav>
                                <div class="nav nav-tabs nav-tabs-justified">
                                    <a class="nav-item nav-link active" id="base-info" data-toggle="tab" href="#base-info-tab">Pamatinformācija</a>
                                    @if($currentUser->hasAccess('user.edit-birthdata'))
                                    <a class="nav-item nav-link" id="birth-info" data-toggle="tab" href="#birth-info-tab">Dzimšanas dati</a>
                                    <a class="nav-item nav-link" id="death-info" data-toggle="tab" href="#death-info-tab">Nāves dati</a>
                                    @endif

                                    @if($currentUser->hasAccess('user.assoc'))
                                    <a class="nav-item nav-link" id="assoc-info" data-toggle="tab" href="#assoc-info-tab">Old!, K!Tēvs, K!Māte</a>
                                    @endif
                                    @if($currentUser->hasAccess('user.history'))
                                    <a class="nav-item nav-link" id="coorp-info" data-toggle="tab" href="#coorp-info-tab">Korporācijas vēsture</a>
                                    @endif
                                    <a class="nav-item nav-link" id="pwd-info" data-toggle="tab" href="#pwd-info-tab">Autorizācija</a>
                                </div>
                            </nav>

                            <hr>
                            <div class="tab-content">

                                <div class="tab-pane fade show active" id="base-info-tab" role="tabpanel">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label required">Vārds</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="name" name="name"
                                                   value="{{$bio->user->name or ''}}" placeholder="Vārds">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="surname" class="col-sm-2 col-form-label required">Uzvārds</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="surname" name="surname"
                                                   value="{{$bio->user->surname or ''}}" placeholder="Uzvārds">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-2 col-form-label">Telefona Numurs</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="+000 00000000" data-toggle="popover" data-placement="top"
                                                   value="{{$bio->user->phone}}">
                                        </div>
                                    </div>

                                    <input type="hidden" value="{{$bio->member_id}}" id="member_id">

                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">E-Pasts</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="email" name="email" data-toggle="popover" data-placement="top"
                                                   value="{{$bio->user->email}}" placeholder="lokālā.daļa@domēns.xx">
                                        </div>
                                    </div>

                                </div>

                                @if($currentUser->hasAccess('user.edit-birthdata'))
                                <div class="tab-pane fade" id="birth-info-tab" role="tabpanel">

                                    <?php
                                    $bDate = $bio->birthdata->date();
                                    if($bDate !== null){
                                        $bDate = \Carbon\Carbon::createFromFormat('d/m/Y', $bDate);
                                    } else {
                                        $bDate = \Carbon\Carbon::today();
                                    }

                                    ?>

                                    <div class="form-group row date">
                                        <label for="birth_date" class="col-sm-2 col-form-label required">Dzimšanas datums</label>
                                        <div class="col-sm-3">
                                            <input type="number" min="1" max="31" required class="form-control" id="birth_day" name="birth_day" value="{{$bDate->day or ''}}" placeholder="DD">
                                        </div>
                                        <?php
                                        if(!isset($bDate)){
                                            $birthMonth = 0;
                                        } else {
                                            $birthMonth = $bDate->month;
                                        }
                                        ?>
                                        <div class="col-sm-3">
                                            <select name="birth_month" class="form-control" id="birth_month">
                                                <option value="1"  @if($birthMonth == 1) selected @endif  >Janvāris</option>
                                                <option value="2"  @if($birthMonth == 2) selected @endif  >Februāris</option>
                                                <option value="3"  @if($birthMonth == 3) selected @endif  >Marts</option>
                                                <option value="4"  @if($birthMonth == 4) selected @endif  >Aprīlis</option>
                                                <option value="5"  @if($birthMonth == 5) selected @endif  >Maijs</option>
                                                <option value="6"  @if($birthMonth == 6) selected @endif  >Jūnijs</option>
                                                <option value="7"  @if($birthMonth == 7) selected @endif  >Jūlijs</option>
                                                <option value="8"  @if($birthMonth == 8) selected @endif  >Augusts</option>
                                                <option value="9"  @if($birthMonth == 9) selected @endif  >Septembris</option>
                                                <option value="10" @if($birthMonth == 10) selected @endif>Oktobris</option>
                                                <option value="11" @if($birthMonth == 11) selected @endif>Novembris</option>
                                                <option value="12" @if($birthMonth == 12) selected @endif>Decembris</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" min="1" required class="form-control" id="birth_year" name="birth_year" value="{{$bDate->year or ''}}" placeholder="GGGG">
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
                                            <input type="text" class="form-control" id="b_country" placeholder="Valsts" name="b_country" value="{{$bio->birthdata->location->country or ''}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="b_city" class="col-sm-2 col-form-label">Pilsēta</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="b_city" placeholder="Pilsēta" name="b_city" value="{{$bio->birthdata->location->city or ''}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="b_country" class="col-sm-2 col-form-label">Adrese</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="b_address" placeholder="Adrese" name="b_address" value="{{$bio->birthdata->location->address or ''}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="b_other" class="col-sm-2 col-form-label">Piezīmes</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="b_other" placeholder="Piezīmes" name="b_other" value="{{$bio->birthdata->location->notes or ''}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="death-info-tab" role="tabpanel">
                                    <div class="form-group row date">

                                        <?php
                                        $dDate = $bio->deathdata->date();
                                        if($dDate !== null){
                                            $dDate = \Carbon\Carbon::createFromFormat('d/m/Y', $dDate);
                                        }
                                        ?>

                                        <label for="deceased_date" class="col-sm-2 col-form-label">Nāves datums</label>
                                        <div class="col-sm-3">
                                            <input type="number" min="1" max="31" class="form-control" id="deceased_day" name="deceased_day" value="{{$dDate->day or ''}}" placeholder="DD">
                                        </div>
                                        <div class="col-sm-3">
                                            <select name="deceased_month" class="form-control" id="deceased_month">
                                                <?php
                                                if(!isset($dDate)){
                                                    $deathMonth = 0;
                                                } else {
                                                    $deathMonth = $dDate->month;
                                                }
                                                ?>
                                                <option value="1" @if($deathMonth == 1) selected @endif >Janvāris</option>
                                                <option value="2" @if($deathMonth == 2) selected @endif >Februāris</option>
                                                <option value="3" @if($deathMonth == 3) selected @endif >Marts</option>
                                                <option value="4" @if($deathMonth == 4) selected @endif >Aprīlis</option>
                                                <option value="5" @if($deathMonth == 5) selected @endif >Maijs</option>
                                                <option value="6" @if($deathMonth == 6) selected @endif >Jūnijs</option>
                                                <option value="7" @if($deathMonth == 7) selected @endif >Jūlijs</option>
                                                <option value="8" @if($deathMonth == 8) selected @endif >Augusts</option>
                                                <option value="9" @if($deathMonth == 9) selected @endif >Septembris</option>
                                                <option value="10"@if($deathMonth == 10) selected @endif>Oktobris</option>
                                                <option value="11"@if($deathMonth == 11) selected @endif>Novembris</option>
                                                <option value="12"@if($deathMonth == 12) selected @endif>Decembris</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" min="1" class="form-control" id="deceased_year" name="deceased_year" value="{{$dDate->year or ''}}" placeholder="GGGG">
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
                                            <input type="text" class="form-control" id="d_country" placeholder="Valsts" name="d_country" value="{{$bio->deathdata->location->country or ''}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="d_city" class="col-sm-2 col-form-label">Pilsēta</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="d_city" placeholder="Pilsēta" name="d_city" value="{{$bio->deathdata->location->city or ''}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="d_country" class="col-sm-2 col-form-label">Adrese</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="d_address" placeholder="Adrese" name="d_address" value="{{$bio->deathdata->location->address or ''}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="d_other" class="col-sm-2 col-form-label">Piezīmes</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="d_other" placeholder="Piezīmes" name="d_other" value="{{$bio->deathdata->location->notes or ''}}">
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($currentUser->hasAccess('user.assoc'))
                                <div class="tab-pane fade" id="assoc-info-tab" role="tabpanel">
                                    <div class="form-group row">
                                        <label for="olderman_input" class="col-sm-2 col-form-label">Oldermanis</label>
                                        <div class="col-sm-5">
                                            <?php
                                            if($bio->olderman != null){
                                                $oldermanField = $bio->olderman->name.' '.$bio->olderman->surname.' ('.$bio->olderman->member_id.')';
                                            }
                                            ?>

                                            <input type="text" placeholder="Vārds Uzvārds (Biedra Numurs)" class="form-control" data-actual-id="" id="olderman_input" name="olderman_input" value="{{$oldermanField or ''}}">
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
                                                               id="olderman_mId" name="olderman_mId">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="olderman_labels">
                                                <div class="row">

                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            userSearchDropdown($('#olderman_input'), $('#oldermanList'), 'olderman-dd-item', 'olderman');
                                        </script>
                                    </div>




                                    <div class="form-group row">
                                        <label for="col_father_input" class="col-sm-2 col-form-label">Krāsu tēvs</label>
                                        <div class="col-sm-5">
                                            <?php
                                            if($bio->colfather != null){
                                                $colFatherField = $bio->colfather->name.' '.$bio->colfather->surname.' ('.$bio->colfather->member_id.')';
                                            }
                                            ?>
                                            <input type="text" placeholder="Vārds Uzvārds (Biedra Numurs)" class="form-control" id="col_father_input" name="col_father_input" value="{{$colFatherField or ''}}">
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
                                                               id="col_father_mId" name="col_father_mId">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="colfather_labels">
                                                <div class="row">

                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            userSearchDropdown($('#col_father_input'), $('#colfatherList'), 'colfather-dd-item', 'col_father');
                                        </script>
                                    </div>

                                    <div class="form-group row">
                                        <label for="col_mother_input" class="col-sm-2 col-form-label">Krāsu māte</label>
                                        <div class="col-sm-5">
                                            <?php
                                            if($bio->colmother != null){
                                                $colMotherField = $bio->colmother->name.' '.$bio->colmother->surname.' ('.$bio->colmother->member_id.')';
                                            }
                                            ?>
                                            <input type="text" placeholder="Vārds Uzvārds (Biedra Numurs)" class="form-control" id="col_mother_input" name="col_mother_input" value="{{$colMotherField or ''}}">
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
                                                               id="col_mother_mId" name="col_mother_mId">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="colmother_labels">
                                                <div class="row">

                                                </div>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            userSearchDropdown($('#col_mother_input'), $('#colmotherList'), 'colmother-dd-item', 'col_mother');
                                        </script>
                                    </div>
                                </div>
                                @endif

                                @if($currentUser->hasAccess('user.history'))
                                <div class="tab-pane fade" id="coorp-info-tab" role="tabpanel">
                                    <div class="form-group row date">

                                        <?php
                                        $sDate = $bio->user->start_date;
                                        ?>

                                        <label for="start_date" class="col-sm-2 col-form-label">Uzņemts V!K!</label>
                                        <div class="col-sm-3">
                                            <input type="number" min="1" max="31" class="form-control" id="start_day" name="start_day" value="{{$sDate->day or ''}}" placeholder="DD">
                                        </div>
                                        <div class="col-sm-3">
                                            <select name="start_month" class="form-control" id="start_month">
                                                <?php
                                                if(!isset($sDate) || $sDate == null){
                                                    $startMonth = 0;
                                                } else {
                                                    $startMonth = $sDate->month;
                                                }
                                                ?>
                                                <option value="1" @if($startMonth == 1) selected @endif >Janvāris</option>
                                                <option value="2" @if($startMonth == 2) selected @endif >Februāris</option>
                                                <option value="3" @if($startMonth == 3) selected @endif >Marts</option>
                                                <option value="4" @if($startMonth == 4) selected @endif >Aprīlis</option>
                                                <option value="5" @if($startMonth == 5) selected @endif >Maijs</option>
                                                <option value="6" @if($startMonth == 6) selected @endif >Jūnijs</option>
                                                <option value="7" @if($startMonth == 7) selected @endif >Jūlijs</option>
                                                <option value="8" @if($startMonth == 8) selected @endif >Augusts</option>
                                                <option value="9" @if($startMonth == 9) selected @endif >Septembris</option>
                                                <option value="10"@if($startMonth == 10) selected @endif>Oktobris</option>
                                                <option value="11"@if($startMonth == 11) selected @endif>Novembris</option>
                                                <option value="12"@if($startMonth == 12) selected @endif>Decembris</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" min="1" class="form-control" id="start_year" name="start_year" value="{{$sDate->year or ''}}" placeholder="GGGG">
                                        </div>

                                        <script>
                                            $(document).ready(function(){
                                                validateDate($("#start_day"),$("#start_month"),$("#start_year"));
                                            })
                                        </script>
                                    </div>

                                    <div class="form-group row date">

                                        <?php
                                        $spkDate = $bio->user->spk_date;
                                        ?>

                                        <label for="spk_date" class="col-sm-2 col-form-label">Uzņemts Sp!K!</label>
                                        <div class="col-sm-3">
                                            <input type="number" min="1" max="31" class="form-control" id="spk_day" name="spk_day" value="{{$spkDate->day or ''}}" placeholder="DD">
                                        </div>
                                        <div class="col-sm-3">
                                            <select name="spk_month" class="form-control" id="spk_month">
                                                <?php
                                                if(!isset($spkDate) || $spkDate == null){
                                                    $spkMonth = 0;
                                                } else {
                                                    $spkMonth = $spkDate->month;
                                                }
                                                ?>
                                                <option value="1" @if($spkMonth == 1) selected @endif >Janvāris</option>
                                                <option value="2" @if($spkMonth == 2) selected @endif >Februāris</option>
                                                <option value="3" @if($spkMonth == 3) selected @endif >Marts</option>
                                                <option value="4" @if($spkMonth == 4) selected @endif >Aprīlis</option>
                                                <option value="5" @if($spkMonth == 5) selected @endif >Maijs</option>
                                                <option value="6" @if($spkMonth == 6) selected @endif >Jūnijs</option>
                                                <option value="7" @if($spkMonth == 7) selected @endif >Jūlijs</option>
                                                <option value="8" @if($spkMonth == 8) selected @endif >Augusts</option>
                                                <option value="9" @if($spkMonth == 9) selected @endif >Septembris</option>
                                                <option value="10"@if($spkMonth == 10) selected @endif>Oktobris</option>
                                                <option value="11"@if($spkMonth == 11) selected @endif>Novembris</option>
                                                <option value="12"@if($spkMonth == 12) selected @endif>Decembris</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" min="1" class="form-control" id="spk_year" name="spk_year" value="{{$spkDate->year or ''}}" placeholder="GGGG">
                                        </div>

                                        <script>
                                            $(document).ready(function(){
                                                validateDate($("#spk_day"),$("#spk_month"),$("#spk_year"));
                                            })
                                        </script>
                                    </div>

                                    <div class="form-group row date">

                                        <?php
                                        $filDate = $bio->user->fil_date;
                                        ?>

                                        <label for="fil_date" class="col-sm-2 col-form-label">Filistrējies</label>
                                        <div class="col-sm-3">
                                            <input type="number" min="1" max="31" class="form-control" id="fil_day" name="fil_day" value="{{$filDate->day or ''}}" placeholder="DD">
                                        </div>
                                        <div class="col-sm-3">
                                            <select name="fil_month" class="form-control" id="fil_month">
                                                <?php
                                                if(!isset($filDate) || $filDate == null){
                                                    $filMonth = 0;
                                                } else {
                                                    $filMonth = $filDate->month;
                                                }
                                                ?>
                                                <option value="1" @if($filMonth == 1) selected @endif >Janvāris</option>
                                                <option value="2" @if($filMonth == 2) selected @endif >Februāris</option>
                                                <option value="3" @if($filMonth == 3) selected @endif >Marts</option>
                                                <option value="4" @if($filMonth == 4) selected @endif >Aprīlis</option>
                                                <option value="5" @if($filMonth == 5) selected @endif >Maijs</option>
                                                <option value="6" @if($filMonth == 6) selected @endif >Jūnijs</option>
                                                <option value="7" @if($filMonth == 7) selected @endif >Jūlijs</option>
                                                <option value="8" @if($filMonth == 8) selected @endif >Augusts</option>
                                                <option value="9" @if($filMonth == 9) selected @endif >Septembris</option>
                                                <option value="10"@if($filMonth == 10) selected @endif>Oktobris</option>
                                                <option value="11"@if($filMonth == 11) selected @endif>Novembris</option>
                                                <option value="12"@if($filMonth == 12) selected @endif>Decembris</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" min="1" class="form-control" id="fil_year" name="fil_year" value="{{$filDate->year or ''}}" placeholder="GGGG">
                                        </div>

                                        <script>
                                            $(document).ready(function(){
                                                validateDate($("#fil_day"),$("#fil_month"),$("#fil_year"));
                                            })
                                        </script>
                                    </div>
                                </div>
                                @endif
                                <div class="tab-pane fade" id="pwd-info-tab" role="tabpanel">
                                    <div class="form-group row">
                                        <label for="old_pwd" class="col-sm-2 col-form-label">Tagadējā parole</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="old_pwd" name="old_pwd">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="new_pwd" class="col-sm-2 col-form-label">Jaunā parole</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="new_pwd" name="new_pwd">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="cnfrm_pwd" class="col-sm-2 col-form-label">Apstipriniet paroli</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="cnfrm_pwd" name="cnfrm_pwd">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="validationBox" class="text-danger">

                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" id="submitBio" class="btn btn-primary">Saglabāt</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script type="application/javascript">
                $(document).ready(function(){
                    var BaseForm         =   $("#bioBaseForm");
                    var BaseModal        =   $("#editBioBaseModal");
                    var BaseArea         =   $("#bioBaseArea");
                    var submitBtn        =   $("#submitBio");

                    validateDates([$("#birth_day"),$("#birth_month"),$("#birth_year")],[$("#deceased_day"),$("#deceased_month"),$("#deceased_year")]);


                    var oldpwd = $("#old_pwd");
                    var newpwd = $("#new_pwd");
                    var cnfrmpwd = $("#cnfrm_pwd");

                    var name_field = $("#name");
                    var surname_field = $("#surname");

                    var phone_field = $('#phone');

                    if(oldpwd.val() == ''){
                        newpwd.prop('disabled', true);
                        cnfrmpwd.prop('disabled', true);
                    }
                    var timeout = null;
                    phone_field.on('change input keyup', function(e) {
                        clearTimeout(timeout);
                        timeout = setTimeout(function () {
                            validate('phone',phone_field.val(),phone_field, true);
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

                    emailTrick([$("#name"),$("#surname"), $("#member_id")], '@talavija-nomail.lv', $("#email"));

                    setTimeout(function(){ oldpwd.val('');}, 50);

                    BaseModal.modal('show');

                    BaseForm.on('submit', function (e) {
                        e.preventDefault();
                        $.ajax({
                            url: $('#bioBaseForm').attr('action'),
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function( msg ) {
                                BaseModal.modal('hide');
                                dataLoader(BaseArea,'/bio/base/get/'+BaseForm.attr('data-memberid'));
                            },
                            error: function (error) {
                                $('#validationBox').html(error);
                                // alert(xhr.msg);
                            }
                        });
                    });

                    $.each([cnfrmpwd, newpwd], function(index){
                       $(this).on('change keyup', function(){
                           var pwdRegEx = new RegExp(/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/);

                           if(cnfrmpwd.val() !== newpwd.val() || !pwdRegEx.test(newpwd.val()) || newpwd.val().length <6){
                               cnfrmpwd.addClass('is-invalid');
                               newpwd.addClass('is-invalid');
                               submitBtn.prop("disabled", true);

                               if(newpwd.val().length <6){
                                   $('#validationBox').html('Parole ir pārāk īsa! Ievadiet vismaz 6 simbolus!');
                                   $('#validationBox').show();
                               } else if(!pwdRegEx.test(newpwd.val())){
                                   $('#validationBox').html('Parole nav pietiekoši sarežģīta! Izmantojiet Ciparus, Lielos un mazos burtus kā arī simbolus!');
                                   $('#validationBox').show();
                               } else if(cnfrmpwd.val() !== newpwd.val()){
                                   $('#validationBox').html('Paroles nesakrīt!');
                                   $('#validationBox').show();
                               }


                           } else {
                               cnfrmpwd.removeClass('is-invalid');
                               newpwd.removeClass('is-invalid');
                               submitBtn.prop("disabled", false);
                               $('#validationBox').hide();
                           }
                       });
                    });

                    oldpwd.on('change keyup keydown', function(){
                        if(oldpwd.val() == ""){
                            newpwd.val('');
                            cnfrmpwd.val('');

                            newpwd.prop("readonly", true);
                            cnfrmpwd.prop("readonly", true);


                        } else {
                            newpwd.prop("readonly", false);
                            cnfrmpwd.prop("readonly", false);
                        }
                    });
                })
            </script>
        </div>
    </div>
</div>
