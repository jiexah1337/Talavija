<div class="modal fade show" id="addWorkplaceModal" tabindex="-1" role="dialog" aria-labelledby="addWorkplaceModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Darba vieta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-pane fade show active" id="residenceTab" role="tabpanel" aria-labelledby="residence-tab">
                    <div>
                        @include('shared.validation-errors')
                        <form method="POST" action="{{$actionurl}}" id="workplaceForm">
                            {{csrf_field()}}
                            <input type="hidden" id="member_id" readonly value="{{$member_id or $workplace->member_id}}" name="member_id">
                            <div class="form-group row">
                                <label for="field" class="col-sm-2 col-form-label required">Nozare</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="field" name="field" value="{{$workplace->field or ''}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="position" class="col-sm-2 col-form-label required">Amats</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="position" name="position" value="{{$workplace->position or ''}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="company" class="col-sm-2 col-form-label required">Uzņēmuma nosaukums</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="company" name="company" value="{{$workplace->company or ''}}">
                                </div>
                            </div>

                            <div class="form-group row date">

                                <?php
                                    if(isset($workplace)){
                                        $w_start_date = $workplace->start_date();
                                        if($w_start_date !== null){
                                            $w_start_date = \Carbon\Carbon::createFromFormat('d/m/Y', $w_start_date );
                                        }
                                    } else {
                                        $w_start_date = null;
                                    }
                                ?>

                                <label for="w_start_date" class="col-sm-2 col-form-label">Sākuma datums</label>
                                <div class="col-sm-3">
                                    <input type="number" min="1" max="31" required class="form-control" id="w_start_day" name="w_start_day" value="{{$w_start_date->day or ''}}" placeholder="DD">
                                </div>
                                <div class="col-sm-3">
                                    <select name="w_start_month" class="form-control" id="w_start_month">
                                        <?php
                                        if(!isset($start_date)){
                                            $month = 0;
                                        } else {
                                            $month = $w_start_date->month;
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
                                    <input type="number" min="1" required class="form-control" id="w_start_year" name="w_start_year" value="{{$w_start_date->year or ''}}" placeholder="GGGG">
                                </div>

                                <script>
                                    $(document).ready(function(){
                                        // validateDate($("#w_start_day"),$("#w_start_month"),$("#w_start_year"));
                                    })
                                </script>
                            </div>

                            <div class="form-group row date">

                                <?php
                                    if(isset($workplace)){
                                        $w_end_date = $workplace->end_date() or null;
                                        if($w_end_date !== null){
                                            $w_end_date = \Carbon\Carbon::createFromFormat('d/m/Y', $w_end_date );
                                        }
                                    } else {
                                        $w_end_date = null;
                                    }

                                ?>

                                <label for="w_end_date" class="col-sm-2 col-form-label">Beigu datums</label>
                                <div class="col-sm-3">
                                    <input type="number" min="1" max="31" class="form-control" id="w_end_day" name="w_end_day" value="{{$w_end_date->day or ''}}" placeholder="DD">
                                </div>
                                <div class="col-sm-3">
                                    <select name="w_end_month" class="form-control" id="w_end_month">
                                        <?php
                                        if(!isset($w_end_date)){
                                            $month = 0;
                                        } else {
                                            $month = $w_end_date->month;
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
                                    <input type="number" min="1" class="form-control" id="w_end_year" name="w_end_year" value="{{$w_end_date->year or ''}}" placeholder="GGGG">
                                </div>

                                <script>
                                    $(document).ready(function(){
                                        // validateDate($("#w_end_day"),$("#w_end_month"),$("#w_end_year"));
                                    })
                                </script>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" id="submitWorkplace" class="btn btn-primary">Saglabāt</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(document).ready(function(){
                    workplaceForm   =   $("#workplaceForm");
                    workplaceModal  =   $("#addWorkplaceModal");
                    workplaceList   =   $("#workplaceList");

                    workplaceModal.modal('show');
                    validateDates([$("#w_start_day"),$("#w_start_month"),$("#w_start_year")],[$("#w_end_day"),$("#w_end_month"),$("#w_end_year")], $("#submitWorkplace"));

                    workplaceForm.on('submit', function (e) {
                        e.preventDefault();

                        if(validateDateOnce($("#w_start_day"),$("#w_start_month"),$("#w_start_year")) && validateDateOnce($("#w_end_day"),$("#w_end_month"),$("#w_end_year"), true))
                        {
                            $.ajax({
                                url: $('#workplaceForm').attr('action'),
                                type: 'POST',
                                data: $(this).serialize(),
                                success: function( msg ) {
                                    workplaceModal.modal('hide');
                                    dataLoader(workplaceList,'/workplace/index/'+$('#member_id').val());
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
