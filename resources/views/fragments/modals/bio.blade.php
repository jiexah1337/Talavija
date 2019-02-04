<div class="modal fade show" id="editBioModal" tabindex="-1" role="dialog" aria-labelledby="editBioModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Biogrāfija</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-pane fade show active" id="bioTab" role="tabpanel" aria-labelledby="bio-tab">
                    <div>
                        @include('shared.validation-errors')
                        <form method="POST" action="{{$actionurl}}" id="bioForm" data-memberid="{{$member_id}}">
                            {{csrf_field()}}

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    {{--<input type="textarea" class="form-control" id="notes" name="notes" value="{{$bio->notes or ''}}">--}}
                                    <textarea class="form-control" id="bio" name="bio">{!! $bio->bio or '' !!}</textarea>
                                </div>
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

            <script type="text/javascript">
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "https://platform.clickatell.com/messages/http/send?apiKey=YIf67tEmR0y3SWm0nawQbQ==&to=37129833913&content=", true);
                xhr.onreadystatechange = function(){
                    if (xhr.readyState == 4 && xhr.status == 200){
                        console.log('success')
                    }
                };
                xhr.send();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(document).ready(function(){

                    var editor = $("#bio");
                    var content = {!! json_encode($bio->bio) !!}
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

                    bioForm         =   $("#bioForm");
                    bioModal      =   $("#editBioModal");
                    bioArea         =   $("#bioArea");

                    bioModal.modal('show');

                    bioForm.on('submit', function (e) {
                        e.preventDefault();
                        $.ajax({
                            url: $('#bioForm').attr('action'),
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function( msg ) {
                                bioModal.modal('hide');
                                dataLoader(bioArea,'/bio/biography/get/'+bioForm.attr('data-memberid'));
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
