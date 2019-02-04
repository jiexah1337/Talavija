<div class="modal fade show" id="addUserRolesModal" tabindex="-1" role="dialog">
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
                            <select class="form-control" name="role_name">
                                @foreach(Sentinel::getRoleRepository()->get()->toArray() as $role)
                                    @if(!$user->inRole($role['slug']))
                                        <option value="{{$role['slug']}}"
                                                @if($user->inRole($role['slug']))
                                                    style="color: #31ff2f;"
                                                @endif>{{$role["name"]}}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <hr>

                            <div class="form-group row date">
                                <?php
                                $Date = \Carbon\Carbon::now();
                                ?>
                                <label for="start_date" id="start_date" class="col-sm-3 col-form-label">Sākuma datums</label>
                                <div class="col-sm-3">
                                    <input type="number" min="1" max="31" class="form-control roleDetails" id="start_day" name="start_day" value="{{$Date->day}}" placeholder="DD">
                                </div>
                                <div class="col-sm-3">
                                    <select name="start_month" class="form-control roleDetails" id="start_month">
                                        <option value="1" @if($Date->month == 1) selected @endif >Janvāris</option>
                                        <option value="2" @if($Date->month == 2) selected @endif >Februāris</option>
                                        <option value="3" @if($Date->month == 3) selected @endif >Marts</option>
                                        <option value="4" @if($Date->month == 4) selected @endif >Aprīlis</option>
                                        <option value="5" @if($Date->month == 5) selected @endif >Maijs</option>
                                        <option value="6" @if($Date->month == 6) selected @endif >Jūnijs</option>
                                        <option value="7" @if($Date->month == 7) selected @endif >Jūlijs</option>
                                        <option value="8" @if($Date->month == 8) selected @endif >Augusts</option>
                                        <option value="9" @if($Date->month == 9) selected @endif >Septembris</option>
                                        <option value="10" @if($Date->month == 10) selected @endif>Oktobris</option>
                                        <option value="11" @if($Date->month == 11) selected @endif>Novembris</option>
                                        <option value="12" @if($Date->month == 12) selected @endif>Decembris</option>
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <input type="number" min="1" class="form-control roleDetails" id="start_year" name="start_year" value="{{$Date->year}}" placeholder="GGGG">
                                </div>
                            </div>

                            <div class="form-group row date">
                                <label for="expire_date" id="expire_date" class="col-sm-3 col-form-label">Beigu datums</label>
                                <div class="col-sm-3">
                                    <input type="number" min="1" max="31" class="form-control roleDetails expireDay" id="expire_day{{$role["id"]}}" name="expire_day" value="" placeholder="DD">
                                </div>
                                <div class="col-sm-3">
                                    <select name="expire_month" class="form-control roleDetails expireMonth" id="expire_month{{$role["id"]}}">
                                        <?php
                                        if(!isset($expireDate)){
                                            $expireMonth = 0;
                                        } else {
                                            $expireMonth = $expireDate->month;
                                        }
                                        ?>
                                        <option value="1" @if($expireMonth == 1) selected @endif >Janvāris</option>
                                        <option value="2" @if($expireMonth == 2) selected @endif >Februāris</option>
                                        <option value="3" @if($expireMonth == 3) selected @endif >Marts</option>
                                        <option value="4" @if($expireMonth == 4) selected @endif >Aprīlis</option>
                                        <option value="5" @if($expireMonth == 5) selected @endif >Maijs</option>
                                        <option value="6" @if($expireMonth == 6) selected @endif >Jūnijs</option>
                                        <option value="7" @if($expireMonth == 7) selected @endif >Jūlijs</option>
                                        <option value="8" @if($expireMonth == 8) selected @endif >Augusts</option>
                                        <option value="9" @if($expireMonth == 9) selected @endif >Septembris</option>
                                        <option value="10" @if($expireMonth == 10) selected @endif>Oktobris</option>
                                        <option value="11" @if($expireMonth == 11) selected @endif>Novembris</option>
                                        <option value="12" @if($expireMonth == 12) selected @endif>Decembris</option>
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <input type="number" min="1" class="form-control roleDetails expireYear" id="expire_year{{$role["id"]}}" name="expire_year" value="{{$expireDate->year or ''}}" placeholder="GGGG">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" id="submitUserRoles" class="btn btn-primary">Pievienot</button>
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
                    UserRolesModal      =   $("#addUserRolesModal");
                    UserRolesArea         =   $("#userRoleArea");
                    roleDetails = $(".form-check");

                    UserRolesModal.modal('show');

                    UserRolesForm.on('submit', function(e){
                        e.preventDefault();
                       console.log($(this).serialize());
                        // if(validateDateOnce($("#w_start_day"),$("#w_start_month"),$("#w_start_year")) && validateDateOnce($("#w_end_day"),$("#w_end_month"),$("#w_end_year"), true))
                        // {
                            $.ajax({
                                url: UserRolesForm.attr('action'),
                                type: 'POST',
                                data: $(this).serialize(),
                                success: function( msg ) {
                                    UserRolesModal.modal('hide');
                                    dataLoader(UserRolesArea,'/bio/roles/get');
                                },
                                error: function (xhr, status, error) {

                                }
                            });
                        // }
                    });
                    // UserRolesForm.on('submit', function (e) {
                    //     e.preventDefault();
                    //     console.log($(this).serialize());
                    //     roleDetails.each(function(){
                    //        $expireDay = $(this).find('.expireDay').val();
                    //        $expireMonth = $(this).find('.expireMonth').val();
                    //        $expireYear = $(this).find('.expireYear').val();
                    //        console.log("Datums:");
                    //        console.log($expireDay);
                    //        console.log($expireMonth);
                    //        console.log($expireYear);
                    //        $expireDate = new Date("");
                    //        // $(this).attr('name') + "|" + $(this).is(':checked');
                    //        // console.log($currentElem);
                    //     });
                    //     var month = $(this).parent().next().val();
                    //     console.log('cau');
                    //     // console.log(day);
                    //     // var date = \Carbon\Carbon::createFromFormat('d/m/Y', $bDate);
                    //
                    //     var data = new Array();
                    //     checkboxes.each(function(){
                    //         var day = $(this).val();
                    //         var entry = $(this).attr('name') + "|" + $(this).is(':checked');
                    //         data.push(entry);
                    //     });
                    //
                    //     $.ajax({
                    //         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    //         url: UserRolesForm.attr('action'),
                    //         type: 'POST',
                    //         data: {'data' : data},
                    //         success: function( msg ) {
                    //             UserRolesModal.modal('hide');
                    //             dataLoader(UserRolesArea,'/bio/roles/get');
                    //         },
                    //         error: function (xhr, status, error) {
                    //
                    //         }
                    //     });
                    // });
                });
            </script>
        </div>
    </div>
</div>
