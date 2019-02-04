<div class="modal fade show" id="editNotesModal" tabindex="-1" role="dialog" aria-labelledby="editNotesModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Biedrziņa piezīmes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-pane fade show active" id="notesTab" role="tabpanel" aria-labelledby="notes-tab">
                    <div>
                        @include('shared.validation-errors')
                        <form method="POST" action="{{$actionurl}}" id="notesForm" data-memberid="{{$member_id}}">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    {{--<input type="textarea" class="form-control" id="notes" name="notes" value="{{$bio->notes or ''}}">--}}
                                    <textarea class="form-control" id="notes" name="notes">{!! $bio->notes or '' !!}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" id="submitNotes" class="btn btn-primary">Saglabāt</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function(){

                    var editor = $("#notes");
                    var content = {!! json_encode($bio->notes) !!}
                    editor.summernote({
                        height: 200,
                        toolbar: [
                            [ 'style', [ 'style' ] ],
                            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                            [ 'fontname', [ 'fontname' ] ],
                            [ 'fontsize', [ 'fontsize' ] ],
                            [ 'color', [ 'color' ] ],
                            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                            [ 'table', [ 'table' ] ],
                            [ 'insert', [ 'link'] ],
                            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
                        ]
                    });
                    editor.summernote('code', content);

                    notesForm         =   $("#notesForm");
                    notesModal      =   $("#editNotesModal");
                    notesArea         =   $("#notesArea");

                    notesModal.modal('show');

                    notesForm.on('submit', function (e) {
                        e.preventDefault();
                        $.ajax({
                            url: $('#notesForm').attr('action'),
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function( msg ) {
                                notesModal.modal('hide');
                                dataLoader(notesArea,'/bio/notes/get/' + notesForm.attr('data-memberid'));
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
