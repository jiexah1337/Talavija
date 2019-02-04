<div class="modal fade show" id="editReportModal" tabindex="-1" role="dialog" aria-labelledby="editReportModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Amata atskaite</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-pane fade show active" id="reportTab" role="tabpanel" aria-labelledby="report-tab">
                    <div>
                        @include('shared.validation-errors')
                        <form method="POST" action="{{$actionurl}}" id="reportForm" data-id="{{$role->id}}">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    {{--<input type="textarea" class="form-control" id="notes" name="notes" value="{{$bio->notes or ''}}">--}}
                                    <textarea class="form-control" id="report" name="report">{!! $roleh->report or '' !!}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" id="submitReport" class="btn btn-primary">Saglabāt</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function(){

                    var editor = $("#report");
                    var content = {!! json_encode($role->report) !!}
                    editor.summernote({
                        height: 200,
                        toolbar: [
                            [ 'style', [ 'style' ] ],
                            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                            [ 'fontname', [ 'fontname' ] ],
                            [ 'fontsize', [ 'fontsize' ] ],
                            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                            [ 'table', [ 'table' ] ],
                        ],

                        popover: [

                        ]
                    });

                    editor.summernote('code', content);

                    notesForm         =   $("#reportForm");
                    notesModal      =   $("#editReportModal");
                    notesArea         =   $("#reportArea");

                    notesModal.modal('show');

                    notesForm.on('submit', function (e) {
                        e.preventDefault();
                        $.ajax({
                            url: $('#reportForm').attr('action'),
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function( msg ) {
                                notesModal.modal('hide');
                                dataLoader(notesArea,'/rolehistory/report/add/'+$('#id').val());
                            },
                            error: function (xhr, status, error) {

                            }
                        });
                    });
                })
            </script>
        </div>
    </div>
</div>
