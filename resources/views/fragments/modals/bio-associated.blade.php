<div class="modal fade show" id="editBioAssocModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Pamatinformācija</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="fade show active">
                    <div>
                        @include('shared.validation-errors')
                        <form method="POST" action="{{$actionurl}}" id="bioAssocForm">
                            {{csrf_field()}}
                            <div class="card-body">



                                <div class="form-group row">
                                    <label for="olderman_input" class="col-sm-2 col-form-label">Oldermanis</label>
                                    <div class="col-sm-5">
                                        <?php
                                            if($bio->olderman != null){
                                                $oldermanField = $bio->olderman->name.' '.$bio->olderman->surname.' ('.$bio->olderman->member_id.')';
                                            }
                                        ?>

                                        <input type="text" required placeholder="Vārds Uzvārds (Biedra Numurs)" class="form-control" data-actual-id="" id="olderman_input" name="olderman_input" value="{{$oldermanField or ''}}">
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
                    Form         =   $("#bioAssocForm");
                    Modal        =   $("#editBioAssocModal");
                    Area         =   $("#bioAssocArea");

                    Modal.modal('show');

                    Form.on('submit', function (e) {
                        e.preventDefault();
                        $.ajax({
                            url: Form.attr('action'),
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function( msg ) {
                                Modal.modal('hide');
                                dataLoader(Area,'/bio/assoc/get');
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
