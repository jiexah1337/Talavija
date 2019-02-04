<div class="modal fade show" id="addResidenceModal" tabindex="-1" role="dialog" aria-labelledby="addResidenceModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Dzīves vieta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-pane fade show active" id="residenceTab" role="tabpanel" aria-labelledby="residence-tab">
                    <div>
                        @include('shared.validation-errors')
                        <form method="POST" action="{{$actionurl}}" id="residenceForm">
                            {{csrf_field()}}
                            <input type="hidden" id="member_id" readonly value="{{$member_id or $residence->member_id}}" name="member_id">

                            <div class="form-group row">
                                <label for="r_country" class="col-sm-2 col-form-label required">Valsts</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="r_country" name="r_country" value="{{$residence->location->country or ''}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="r_city" class="col-sm-2 col-form-label required">Pilseta</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="r_city" name="r_city" value="{{$residence->location->city or ''}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="r_address" class="col-sm-2 col-form-label required">Adrese</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="r_address" name="r_address" value="{{$residence->location->address or ''}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="r_notes" class="col-sm-2 col-form-label">Piezīmes</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="r_notes" name="r_notes" value="{{$residence->location->notes or ''}}">
                                </div>
                            </div>

                            <div class="form-group row date">

                                <?php
                                if(isset($residence)){
                                    $start_date = $residence->start_date();
                                    if($start_date !== null){
                                        $start_date = \Carbon\Carbon::createFromFormat('d/m/Y', $start_date );
                                    }
                                } else {
                                    $start_date = null;
                                }
                                ?>

                                <label for="start_date" class="col-sm-2 col-form-label">Sākuma datums</label>
                                <div class="col-sm-3">
                                    <input type="number" min="1" max="31" required class="form-control" id="start_day" name="start_day" value="{{$start_date->day or ''}}" placeholder="DD">
                                </div>
                                <div class="col-sm-3">
                                    <select name="start_month" class="form-control" id="start_month">
                                        <?php
                                        if(!isset($start_date)){
                                            $month = 0;
                                        } else {
                                            $month = $start_date->month;
                                        }
                                        ?>
                                        <option value="1" @if($month == 1) selected @endif >Janvāris</option>
                                        <option value="2" @if($month == 2) selected @endif >Februāris</option>
                                        <option value="3" @if($month == 3) selected @endif >Marts</option>
                                        <option value="4" @if($month == 4) selected @endif >Aprīlis</option>
                                        <option value="5" @if($month == 5) selected @endif >Maijs</option>
                                        <option value="6" @if($month == 6) selected @endif >Jūnijs</option>
                                        <option value="7" @if($month == 7) selected @endif >Jūlijs</option>
                                        <option value="8" @if($month == 8) selected @endif >Augusts</option>
                                        <option value="9" @if($month == 9) selected @endif >Septembris</option>
                                        <option value="10"@if($month == 10) selected @endif>Oktobris</option>
                                        <option value="11"@if($month == 11) selected @endif>Novembris</option>
                                        <option value="12"@if($month == 12) selected @endif>Decembris</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="number" min="1" required class="form-control" id="start_year" name="start_year" value="{{$start_date->year or ''}}" placeholder="GGGG">
                                </div>

                                <script>
                                    $(document).ready(function(){
                                        // validateDate($("#start_day"),$("#start_month"),$("#start_year"));
                                    })
                                </script>
                            </div>

                            <div class="form-group row date">

                                <?php
                                if(isset($residence)){
                                    $end_date = $residence->end_date() or null;
                                    if($end_date !== null){
                                        $end_date = \Carbon\Carbon::createFromFormat('d/m/Y', $end_date );
                                    }
                                } else {
                                    $end_date = null;
                                }

                                ?>

                                <label for="end_date" class="col-sm-2 col-form-label">Beigu datums</label>
                                <div class="col-sm-3">
                                    <input type="number" min="1" max="31" class="form-control" id="end_day" name="end_day" value="{{$end_date->day or ''}}" placeholder="DD">
                                </div>
                                <div class="col-sm-3">
                                    <select name="end_month" class="form-control" id="end_month">
                                        <?php
                                        if(!isset($end_date)){
                                            $month = 0;
                                        } else {
                                            $month = $end_date->month;
                                        }
                                        ?>
                                        <option value="1" @if($month == 1) selected @endif >Janvāris</option>
                                        <option value="2" @if($month == 2) selected @endif >Februāris</option>
                                        <option value="3" @if($month == 3) selected @endif >Marts</option>
                                        <option value="4" @if($month == 4) selected @endif >Aprīlis</option>
                                        <option value="5" @if($month == 5) selected @endif >Maijs</option>
                                        <option value="6" @if($month == 6) selected @endif >Jūnijs</option>
                                        <option value="7" @if($month == 7) selected @endif >Jūlijs</option>
                                        <option value="8" @if($month == 8) selected @endif >Augusts</option>
                                        <option value="9" @if($month == 9) selected @endif >Septembris</option>
                                        <option value="10"@if($month == 10) selected @endif>Oktobris</option>
                                        <option value="11"@if($month == 11) selected @endif>Novembris</option>
                                        <option value="12"@if($month == 12) selected @endif>Decembris</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="number" min="1" class="form-control" id="end_year" name="end_year" value="{{$end_date->year or ''}}" placeholder="GGGG">
                                </div>

                                <script>
                                    $(document).ready(function(){
                                        // validateDate($("#end_day"),$("#end_month"),$("#end_year"));
                                        // validateDates([$("#start_day"),$("#start_month"),$("#start_year")],[$("#end_day"),$("#end_month"),$("#end_year")], $("#submitResidence"))
                                    })
                                </script>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" id="submitResidence" class="btn btn-primary">Saglabāt</button>
                                </div>
                            </div>
                        </form>
                        <script>
                            $('#r_start_date').datepicker();
                            $('#r_end_date').datepicker();
                        </script>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function(){
                    residenceForm   =   $("#residenceForm");
                    residenceModal  =   $("#addResidenceModal");
                    residenceList   =   $("#residenceList");

                    residenceModal.modal('show');
                    validateDates([$("#start_day"),$("#start_month"),$("#start_year")],[$("#end_day"),$("#end_month"),$("#end_year")], $("#submitResidence"));

                    residenceForm.on('submit', function (e) {
                        e.preventDefault();
                        if(validateDateOnce($("#start_day"),$("#start_month"),$("#start_year")) && validateDateOnce($("#end_day"),$("#end_month"),$("#end_year"), true)) {
                            $.ajax({
                                url: $('#residenceForm').attr('action'),
                                type: 'POST',
                                data: $(this).serialize(),
                                success: function (msg) {
                                    residenceModal.modal('hide');
                                    dataLoader(residenceList, '/residence/index/'+$('#member_id').val());

                                },
                                error: function (xhr, status, error) {

                                }
                            });
                        }
                    });
                })
            </script>
        </div>
    </div>
</div>
