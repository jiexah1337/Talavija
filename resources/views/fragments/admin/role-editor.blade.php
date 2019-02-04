<form id="roleForm">
    {{ csrf_field() }}
    <div class="card">
        <div class="card-header bg-dark text-light">
            <div class="pull-left">
                Amati un atļaujas
            </div>
            <div class="pull-right">
                <a href="#" id="addBtn"
                   class="text-warning" data-toggle="tooltip" title="Pievienot jaunu statusu">
                    <i class="fas fa-plus"></i>
                </a>
                <a href="#" id="saveBtn"
                   class="text-primary" data-toggle="tooltip" title="Saglabāt">
                    <i class="fas fa-save"></i>
                </a>
                <a href="#" id="cancelBtn"
                   class="text-danger" data-toggle="tooltip" title="Atcelt">
                    <i class="fas fa-ban"></i>
                </a>
            </div>
        </div>

        <div class="card-body">
            @foreach($roles as $role)
                <div class="card role-box">
                    <a data-toggle="collapse" href="#{{$role["slug"]}}">
                        <div class="card-header bg-dark text-light">
                            {{$role["name"]}} ({{$role["slug"]}})
                        </div>
                    </a>

                    <div class="collapse card-body" id="{{$role["slug"]}}">
                        <div class="form-check text-danger">
                            <input class="form-check-input roledeletecheck" type="checkbox" id="{{$role["slug"]."|"."delete-mark"}}" name="{{$role["slug"]."|"."delete-mark"}}">
                            <label class="form-check-label" for="{{$role["slug"]."|"."delete-mark"}}">
                                Atzīmēt dzēšanai
                            </label>
                        </div>
                        <hr>
                        @foreach($permList as $perm)
                                <div class="form-check">
                                    <input class="form-check-input rolecheck" @if(array_key_exists($perm["name"], $role["permissions"]) && $role["permissions"][$perm["name"]] == true) checked @endif type="checkbox" id="{{$role["slug"]."|".$perm["name"]}}" name="{{$role["slug"]."|".$perm["name"]}}">
                                    <label class="form-check-label" for="{{$role["slug"]."|".$perm["name"]}}">
                                        {{$perm["desc"]}}
                                    </label>
                                </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <script type="text/javascript">
        tooltipInit();
        var thisForm = $("#roleForm");
        var editorArea = $("#editorArea");

        var closeBtn = $("#cancelBtn");
        var saveBtn = $("#saveBtn");
        var addBtn = $("#addBtn");

        closeBtn.on('click', function(e){
            e.preventDefault();
            editorArea.slideUp().done(function(){
                thisForm.remove();
            });

        });

        saveBtn.on('click', function(e){
           e.preventDefault();

            var checkboxes = $(".rolecheck");
            var deletemarks = $(".roledeletecheck");
            var data = new Array();
            var deleteddata = new Array();

            checkboxes.each(function(){
                var entry = $(this).attr('name') + "|" + $(this).is(':checked');
                data.push(entry);
            });

            deletemarks.each(function(){
                var entry = $(this).attr('name') + "|" + $(this).is(':checked');
                deleteddata.push(entry);
            });

           $.ajax({
               headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
               type: 'POST',
               url: '/admin/roles/edit',
               data: {"data" : data , "deleted" : deleteddata},
               success: function (data) {
                   editorArea.slideUp();
                   $("#roleBox").html(data.list);
               }
           })
        });

        addBtn.on('click', function(e){
            e.preventDefault();
            $.ajax({
                type: 'GET',
                url: '/admin/roles/add',
                success: function (data) {
                     $("#modalBox").html(data.html);
                }
            })
        });
    </script>
</form>
