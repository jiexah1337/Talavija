<div class="modal fade show" id="editBioFamilyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Ģimene</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="fade show active">
                    <div>
                        @include('shared.validation-errors')
                        <form method="POST" action="{{$actionurl}}" id="bioFamilyForm" data-memberid="{{$member_id}}">
                            {{csrf_field()}}

                            <div class="tab-pane fade show active" id="base-info-tab" role="tabpanel">
                                <div class="form-group row">
                                    <label for="father" class="col-sm-3 col-form-label">Tēvs</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Tēvs" id="father" name="father" value="{{$bio->father or ''}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="mother" class="col-sm-3 col-form-label">Māte</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="Māte" id="mother" name="mother" value="{{$bio->mother or ''}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="children" class="col-sm-3 col-form-label">Pēcteči (Atdalīt ar ",")</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="children" name="children">{{implode(',' ,(array) json_decode($bio->children))}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="other" class="col-sm-3 col-form-label">Citi (Atdalīt ar ",")</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="other" name="other">{{implode(',' ,(array) json_decode($bio->otherfamily))}}</textarea>
                                    </div>
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
                $(document).ready(function(){
                    BaseForm         =   $("#bioFamilyForm");
                    BaseModal        =   $("#editBioFamilyModal");
                    BaseArea         =   $("#bioFamilyArea");

                    BaseModal.modal('show');

                    BaseForm.on('submit', function (e) {
                        e.preventDefault();
                        $.ajax({
                            url: BaseForm.attr('action'),
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function( msg ) {
                                BaseModal.modal('hide');
                                dataLoader(BaseArea,'/bio/family/get/' + BaseForm.attr('data-memberid'));
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
