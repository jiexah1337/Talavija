<div class="modal fade show" id="editUserRolesModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Amati</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-pane fade show active" id="bioTab" role="tabpanel">
                    <div>
                        @include('shared.validation-errors')
                        <form method="POST" action="{{$actionurl}}" id="userRolesForm">
                            {{csrf_field()}}

                            <div>
                                @foreach(Sentinel::getRoleRepository()->get()->toArray() as $role)
                                    <div class="form-check">
                                        <input class="form-check-input userrolecheck" type="checkbox"
                                               @if($user->inRole($role['slug']))
                                               checked
                                               @endif
                                               id="{{$role["slug"]}}" name="{{$role["slug"]}}">
                                        <label class="form-check-label" for="{{$role["slug"]}}">
                                            {{$role["name"]}}
                                        </label>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" id="submitUserRoles" class="btn btn-primary">Saglabāt</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(document).ready(function(){
                    UserRolesForm         =   $("#userRolesForm");
                    UserRolesModal      =   $("#editUserRolesModal");
                    UserRolesArea         =   $("#userRoleArea");

                    UserRolesModal.modal('show');



                    UserRolesForm.on('submit', function (e) {
                        e.preventDefault();

                        var checkboxes = $(".userrolecheck");
                        var data = new Array();

                        checkboxes.each(function(){
                            var entry = $(this).attr('name') + "|" + $(this).is(':checked');
                            data.push(entry);
                        });

                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            url: UserRolesForm.attr('action'),
                            type: 'POST',
                            data: {'data' : data},
                            success: function( msg ) {
                                UserRolesModal.modal('hide');
                                dataLoader(UserRolesArea,'/bio/roles/get');
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
