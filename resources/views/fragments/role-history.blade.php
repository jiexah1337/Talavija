{{--@foreach($user->roles()->get() as $role)--}}
    {{--{{$role->name}} <br>--}}
{{--@endforeach--}}
<tr>
    <?php if($canUpdate):?>
        <td style="vertical-align: middle">
            <a href="#" id="deleteHistory" data-id="{{$roleh->id}}" target="_blank"
               class="text-danger" data-toggle="tooltip" title="Dzēst">
                <i class="fas fa-minus-square"></i>
            </a>
        </td>
    <?php endif ?>

    <td style="vertical-align: middle">{{$roleh->role_id}}</td>
    <td style="vertical-align: middle">{{$roleh->start_date->toDateString()}}</td>
    <td style="vertical-align: middle">{{$roleh->expire_date or ''}}</td>
    <td style="vertical-align: middle">
        @if (is_null($roleh->report))
            <a href="#" id="addReport" data-id="{{$roleh->id}}" target="_blank"
               class="text-primary" data-toggle="tooltip">Rakstīt
            </a>
            <br>
            <a href="#" id="uploadReportFile" data-id="{{$user->member_id}}" target="_blank"
                class="text-primary" data-toggle="tooltip">Augšupielādēt
            </a>
        @else
            <a href="/rolehistory/generate-pdf/{{$user->member_id}}/{{$roleh->id}}" target="_blank"
               class="text-primary" data-toggle="tooltip" title="Atvērt amata atskaiti (.PDF)">
                <i class="fas fa-file-pdf"></i>
            </a>
            <?php if($canUpdate):?>
                <a href="#" id="addReport" data-id="{{$roleh->id}}" target="_blank"
                   class="text-warning" data-toggle="tooltip" title="Rediģēt">
                    <i class="fas fa-pen-square"></i>
                </a>
                <a href="/rolehistory/report/delete/{{$roleh->id}}" target="_blank"
                   class="text-danger" data-toggle="tooltip" title="Dzēst">
                    <i class="fas fa-minus-square"></i>
                </a>
            <?php endif ?>
        @endif
    </td>
</tr>

<div id="modalContainer">

</div>

<script type="text/javascript">
    $(document).ready(function(){
        addReport    =   $("#addReport");
        uploadReportFile = $("#uploadReportFile");

        $('a[id^="addReport"]').unbind().on("click", function(e){
            e.preventDefault();
            $.ajax({
                type: 'GET',
                url: '/rolehistory/report/add/'+$(this).data('id'),
                success: function(data){
                    $('#modalContainer').html(data.html);
                }
            });

        });

        $('a[id^="uploadReportFile"]').unbind().on("click", function(e){
            e.preventDefault();
            $.ajax({
                type: 'GET',
                url: '/rolehistory/report/upload/'+$(this).data('id'),
                success: function(data){
                    $('#modalContainer').html(data.html);
                }
            });

        });

        $('a[id^="deleteHistory"]').unbind().on("click", function(e){
            e.preventDefault();
            $.ajax({
                type: 'GET',
                url: '/rolehistory/delete/'+$(this).data('id'),
                success: function(data){
                    alert(data.msg);
                },
                error: function(data){
                    alert(data.msg);
                }
            });

        });

    })
</script>