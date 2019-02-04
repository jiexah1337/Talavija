<div class="modal fade show" id="addStudyModal" tabindex="-1" role="dialog" aria-labelledby="addStudyModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Mācību iestāde</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-pane fade show active" id="residenceTab" role="tabpanel" aria-labelledby="residence-tab">
                    <div>
                        @include('shared.validation-errors')
                        <form method="POST" action="{{$actionurl}}" id="studyForm">
                            {{csrf_field()}}
                            <input type="hidden" id="member_id" readonly value="{{$member_id or $study->member_id}}" name="member_id">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label required">Nosaukums</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="name" name="name" value="{{$study->name or ''}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="faculty" class="col-sm-2 col-form-label">Fakultāte</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="faculty" name="faculty" value="{{$study->faculty or ''}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="program" class="col-sm-2 col-form-label">Programma</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="program" name="program" value="{{$study->program or ''}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="degree" class="col-sm-2 col-form-label">Grāds/Kvalifikācija</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="degree" name="degree" value="{{$study->degree or ''}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="graduated" class="col-sm-2 col-form-label">Absolvējis</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" @if(isset($study) && $study->graduated == true) checked @endif class="form-control" id="graduated" name="graduated" value="{{$study->graduated or 0}}">
                                </div>
                            </div>

                            <div class="form-group row date">

                                <?php
                                if(isset($study)){
                                    $start_date = $study->start_date();
                                    if($start_date !== null){
                                        $start_date = \Carbon\Carbon::createFromFormat('d/m/Y', $start_date );
                                    }
                                } else {
                                    $start_date = null;
                                }
                                ?>

                                <label for="start_date" class="col-sm-2 col-form-label">Sākuma datums</label>
                                <div class="col-sm-3">
                                    <input type="number" min="1" max="31" required class="form-control" id="start_day" name="start_day" value="{{$start_date->day or '1'}}" placeholder="DD">
                                </div>
                                <div class="col-sm-3">
                                    <select name="start_month" class="form-control" id="start_month">
                                        <?php
                                        if(!isset($start_date)){
                                            $month = 9;
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
                                if(isset($study)){
                                    $end_date = $study->end_date() or null;
                                    if($end_date !== null){
                                        $end_date = \Carbon\Carbon::createFromFormat('d/m/Y', $end_date );
                                    }
                                } else {
                                    $end_date = null;
                                }

                                ?>

                                <label for="end_date" class="col-sm-2 col-form-label">Beigu datums</label>
                                <div class="col-sm-3">
                                    <input type="number" min="1" max="31" class="form-control" id="end_day" name="end_day" value="{{$end_date->day or '30'}}" placeholder="DD">
                                </div>
                                <div class="col-sm-3">
                                    <select name="end_month" class="form-control" id="end_month">
                                        <?php
                                        if(!isset($end_date)){
                                            $month = 6;
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
                                    })
                                </script>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" id="submitStudy" class="btn btn-primary">Saglabāt</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(document).ready(function(){
                    studyForm       =   $("#studyForm");
                    studyModal      =   $("#addStudyModal");
                    studyList       =   $("#studyList");

                    studyModal.modal('show');
                    validateDates([$("#start_day"),$("#start_month"),$("#start_year")],[$("#end_day"),$("#end_month"),$("#end_year")], $("#submitStudy"));

                    studyForm.on('submit', function (e) {
                        e.preventDefault();

                        if(validateDateOnce($("#start_day"),$("#start_month"),$("#start_year")) && validateDateOnce($("#end_day"),$("#end_month"),$("#end_year"), true)) {
                            $.ajax({
                                url: $('#studyForm').attr('action'),
                                type: 'POST',
                                data: $(this).serialize(),
                                success: function (msg) {
                                    studyModal.modal('hide');
                                    dataLoader(studyList, '/study/index/'+$('#member_id').val());
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
