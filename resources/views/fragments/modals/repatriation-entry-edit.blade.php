<div class="modal fade show" id="repatriationEntryModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <div class="modal-title">
                    Rediģēt ierakstu
                </div>

                <button type="button" class="close" data-dismiss="modal" id="repatriationEntryModalClose" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="fade show">
                    <div>
                        @include('shared.validation-errors')
                        <form method="POST" action="{{$actionurl}}" id="repatriationEntryForm">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$rep->id or ''}}">
                            <input type="hidden" name="member_id" value="{{$rep->member_id}}">
                            <input type="hidden" name="year" value="{{$rep->year}}">
                            <input type="hidden" name="month" value="{{$rep->month}}">


                            <div class="form-group row">
                                <label for="rep-title" class="col-sm-2 col-form-label">Nosaukums</label>
                                <input type="text" class="form-control" id="rep-title" name="title" value="{{$rep->title or ''}}">
                            </div>

                            <div class="form-group row date">

                                <?php
                                $issueDate = $rep->issue_date;
                                ?>

                                <label for="issue_date" class="col-sm-2 col-form-label">Pierakstīšanas datums</label>
                                <div class="col-sm-3">
                                    <input type="number" min="1" max="31" class="form-control" id="issue_day" name="issue_day" value="{{$issueDate->day or ''}}" placeholder="DD">
                                </div>
                                <div class="col-sm-3">
                                    <select name="issue_month" class="form-control" id="issue_month">
                                        <?php
                                        if(!isset($issueDate) || $issueDate == null){
                                            $issueMonth = 0;
                                        } else {
                                            $issueMonth = $issueDate->month;
                                        }
                                        ?>
                                        <option value="1" @if($issueMonth == 1) selected @endif >Janvāris</option>
                                        <option value="2" @if($issueMonth == 2) selected @endif >Februāris</option>
                                        <option value="3" @if($issueMonth == 3) selected @endif >Marts</option>
                                        <option value="4" @if($issueMonth == 4) selected @endif >Aprīlis</option>
                                        <option value="5" @if($issueMonth == 5) selected @endif >Maijs</option>
                                        <option value="6" @if($issueMonth == 6) selected @endif >Jūnijs</option>
                                        <option value="7" @if($issueMonth == 7) selected @endif >Jūlijs</option>
                                        <option value="8" @if($issueMonth == 8) selected @endif >Augusts</option>
                                        <option value="9" @if($issueMonth == 9) selected @endif >Septembris</option>
                                        <option value="10"@if($issueMonth == 10) selected @endif>Oktobris</option>
                                        <option value="11"@if($issueMonth == 11) selected @endif>Novembris</option>
                                        <option value="12"@if($issueMonth == 12) selected @endif>Decembris</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="number" min="1" class="form-control" id="issue_year" name="issue_year" value="{{$issueDate->year or ''}}" placeholder="GGGG">
                                </div>

                                <script>
                                    $(document).ready(function(){
                                        validateDate($("#issue_day"),$("#issue_month"),$("#issue_year"));
                                    })
                                </script>
                            </div>


                            <div class="form-group row"r>
                                <label for="rep-amount" class="col-sm-2 col-form-label">Daudzums (&euro;)</label>
                                <input type="number" step="0.01" class="form-control" id="rep-amount" name="amount" value="{{$rep->amount or ''}}">
                            </div>


                            <div class="form-group row date">

                                <?php
                                $paidDate = $rep->paid_date;
                                ?>

                                <label for="paid_date" class="col-sm-2 col-form-label">Saņemšanas datums</label>
                                <div class="col-sm-3">
                                    <input type="number" min="1" max="31" class="form-control" id="paid_day" name="paid_day" value="{{$paidDate->day or ''}}" placeholder="DD">
                                </div>
                                <div class="col-sm-3">
                                    <select name="paid_month" class="form-control" id="paid_month">
                                        <?php
                                        if(!isset($paidDate) || $paidDate == null){
                                            $paidMonth = 0;
                                        } else {
                                            $paidMonth = $paidDate->month;
                                        }
                                        ?>
                                        <option value="1" @if($paidMonth == 1) selected @endif >Janvāris</option>
                                        <option value="2" @if($paidMonth == 2) selected @endif >Februāris</option>
                                        <option value="3" @if($paidMonth == 3) selected @endif >Marts</option>
                                        <option value="4" @if($paidMonth == 4) selected @endif >Aprīlis</option>
                                        <option value="5" @if($paidMonth == 5) selected @endif >Maijs</option>
                                        <option value="6" @if($paidMonth == 6) selected @endif >Jūnijs</option>
                                        <option value="7" @if($paidMonth == 7) selected @endif >Jūlijs</option>
                                        <option value="8" @if($paidMonth == 8) selected @endif >Augusts</option>
                                        <option value="9" @if($paidMonth == 9) selected @endif >Septembris</option>
                                        <option value="10"@if($paidMonth == 10) selected @endif>Oktobris</option>
                                        <option value="11"@if($paidMonth == 11) selected @endif>Novembris</option>
                                        <option value="12"@if($paidMonth == 12) selected @endif>Decembris</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="number" min="1" class="form-control" id="paid_year" name="paid_year" value="{{$paidDate->year or ''}}" placeholder="GGGG">
                                </div>

                                <script>
                                    $(document).ready(function(){
                                        validateDate($("#paid_day"),$("#paid_month"),$("#paid_year"));
                                    })
                                </script>
                            </div>

                            <div class="form-group row">
                                <label for="rep-collect" class="col-sm-2 col-form-label">Saņemts (&euro;)</label>
                                <input type="number" step="0.01" class="form-control" id="rep-collect" name="collect" value="{{$rep->collect or ''}}">
                            </div>

                            <div class="form-group row">
                                <label for="rep-type" class="col-sm-2 col-form-label">Tips</label>
                                <select class="form-control" id="rep-type" name="type">
                                    <option @if($rep->type == 'Maksājums') selected="selected" @endif value="Maksājums">Maksājums</option>
                                    <option @if($rep->type == 'Sods') selected="selected" @endif value="Sods">Sods</option>
                                    <option @if($rep->type == 'Prēmija') selected="selected" @endif value="Prēmija">Prēmija</option>
                                    <option @if($rep->type == 'Cits') selected="selected" @endif value="Cits">Cits</option>
                                </select>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" id="submitRepEntry" class="btn btn-primary">Saglabāt</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function(){
                    Form   =   $("#repatriationEntryForm");
                    Modal  =   $("#repatriationEntryModal");

                    Modal.modal('show');

                    Form.on('submit', function (e) {
                        e.preventDefault();
                        $.ajax({
                            url: Form.attr('action'),
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function( data ) {
                                Modal.modal('hide');
                                dataLoader($('#monthlyList'), data.gllURL);
                                alert(data.msg);
                            },
                            error: function (xhr, status, error) {
                                alert(xhr.msg);
                            }
                        });
                    });
                })
            </script>
        </div>
    </div>
</div>
