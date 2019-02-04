<div class="modal fade show" id="newNewsModal" tabindex="-1" role="dialog" aria-labelledby="newNewsModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Jauns ziņojums</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-pane fade show active" id="newNewsTab" role="tabpanel" aria-labelledby="newNews-tab">
                    <div>
                        @include('shared.validation-errors')
                        <form method="POST" action="{{$actionurl}}" id="newNewsForm">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label for="rep-title" class="col-sm-2 col-form-label required">Nosaukums</label>
                                <input type="text" required class="form-control col-sm-10" id="rep-title" name="title" value="">
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-sm-2 col-form-label">Tips</label>
                                <select name="type" class="form-control col-sm-10" id="type">
                                    <option value="default">Parasts ziņojums</option>
                                    <option value="info" class="bg-info text-light">Informatīvs ziņojums</option>
                                    <option value="warning" class="bg-warning text-dark">Svarīgs ziņojums</option>
                                    <option value="danger" class="bg-danger text-dark">Ļoti svarīgs ziņojums</option>
                                    <option value="brand" class="bg-success text-light">Zīmogots ziņojums</option>
                                </select>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <textarea class="form-control" id="content" name="content"> </textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" id="submitNews" class="btn btn-primary">Saglabāt</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function(){

                    var editor = $("#content");
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
                        ]});
                    editor.summernote('code', '');

                    Form         =   $("#newNewsForm");
                    Modal      =   $("#newNewsModal");
                    Area         =   $("#news-box");

                    Modal.modal('show');

                    Form.on('submit', function (e) {
                        e.preventDefault();
                        $("#submitNews").prop("disabled", true);
                        $.ajax({
                            url: Form.attr('action'),
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function( msg ) {
                                Modal.modal('hide');
                                dataLoader(Area,'/news/index/1');
                            },
                            error: function (xhr, status, error) {
                                $("#submitNews").prop("disabled", false);
                            }
                        });
                    });
                })
            </script>
        </div>
    </div>
</div>
