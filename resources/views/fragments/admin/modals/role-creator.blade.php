<div class="modal fade show" id="addRoleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Pievienot jaunu amatu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-pane fade show active" id="addRoleTab" role="tabpanel">
                    <div>
                        @include('shared.validation-errors')
                        <form method="POST" action="{{$actionurl}}" id="addRoleForm">
                            {{csrf_field()}}
                            @include('shared.validation-errors')
                            <div class="form-group row">
                                <label for="role-name" class="col-sm-2 col-form-label required">Nosaukums</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="role-name" name="role-name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="role-abbr" class="col-sm-2 col-form-label required">Saīsinājums</label>
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" id="role-abbr" name="role-abbr">
                                </div>
                            </div>

                            <div>
                                @foreach($permList as $perm)
                                    <div class="form-check">
                                        <input class="form-check-input newrolecheck" type="checkbox" id="{{$perm["name"]}}" name="{{$perm["name"]}}">
                                        <label class="form-check-label" for="{{$perm["name"]}}">
                                            {{$perm["desc"]}}
                                        </label>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" id="submitResidence" class="btn btn-primary">Saglabāt</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function(){
                    thisForm   =   $("#addRoleForm");
                    thisModal  =   $("#addRoleModal");
                    targetList   =   $("#List");
                    var rolesEditBtn = $("#roles-list-btn");

                    thisModal.modal('show');

                    thisForm.on('submit', function (e) {
                        e.preventDefault();



                        var checkboxes = $(".newrolecheck");
                        var data = new Array();

                        checkboxes.each(function(){
                            var entry = $(this).attr('name') + "|" + $(this).is(':checked');
                            data.push(entry);
                        });

                        var name = $("#role-name").val();
                        var slug = $("#role-abbr").val();


                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            url: thisForm.attr('action'),
                            type: 'POST',
                            data: {'data' : data, 'name' : name, 'slug' : slug},
                            success: function( msg ) {
                                thisModal.modal('hide');
                                dataLoader(targetList,'/admin/roles/list');
                                rolesEditBtn.click();

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
