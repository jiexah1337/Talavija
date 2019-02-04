<form id="statusForm">
    {{ csrf_field() }}
    <div class="card">
        <div class="card-header bg-dark text-light">
            <div class="pull-left">
                Statusi
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
            @foreach($statuses as $status)
                <div class="card status-box">
                    <a data-toggle="collapse" href="#{{$status->id}}">
                        <div class="card-header bg-dark text-light">
                            {{$status->title}} ({{$status->abbreviation}})
                        </div>
                    </a>

                    <div class="collapse card-body" id="{{$status->id}}">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary btn-set-default-status" data-status="{{$status->id}}">Padarīt par noklusējumu</button>
                            <button type="button" class="btn btn-secondary" data-status="{{$status->id}}"><span class="nyi">Rediģēt</span></button>
                            <button type="button" data-status="{{$status->id}}" @if($status->default) disabled data-toggle="tooltip" data-placement="bottom" title="Aizliegts dzēst noklusējuma statusu!" @endif class="btn btn-secondary btn-delete-status">Dzēst</button>
                        </div>
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
        var statusEditBtn = $("#status-list-btn");

        var setDefaultBtns = $(".btn-set-default-status");
        setDefaultBtns.each(function (index) {
            $(this).on('click', function(e){
                var id = $(this).attr('data-status');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: '/admin/statuses/default/' + id,
                    type: 'POST',
                    success: function(data){
                        alert(data.msg);
                        statusEditBtn.click();
                    },
                    error: function(data){
                        alert(data.msg);
                    }
                })
            })
        });

        var deleteBtns = $(".btn-delete-status");
        deleteBtns.each(function (index){
            $(this).on('click', function(e){
                var id = $(this).attr('data-status');
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: '/admin/statuses/delete/' + id,
                    type: 'POST',
                    success: function(data){
                        alert(data.msg);
                        statusEditBtn.click();
                    },
                    error: function(data){
                        alert(data.msg);
                    }
                })
            })
        });

        closeBtn.on('click', function(e){
            e.preventDefault();
            editorArea.slideUp().done(function(){
                thisForm.remove();
            });

        });

        saveBtn.on('click', function(e){
            e.preventDefault();

            // var checkboxes = $(".rolecheck");
            // var data = new Array();
            //
            // checkboxes.each(function(){
            //     var entry = $(this).attr('name') + "|" + $(this).is(':checked');
            //     data.push(entry);
            // });

            // $.ajax({
            //     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //     type: 'POST',
            //     url: '/admin/roles/edit',
            //     data: {"data" : data },
            //     success: function (data) {
            //         editorArea.slideUp().done(function(){
            //             thisForm.remove();
            //         });
            //     }
            // })
        });

        addBtn.on('click', function(e){
            e.preventDefault();
            $.ajax({
                type: 'GET',
                url: '/admin/statuses/add',
                success: function (data) {
                    $("#modalBox").html(data.html);
                }
            })
        });
    </script>
</form>
