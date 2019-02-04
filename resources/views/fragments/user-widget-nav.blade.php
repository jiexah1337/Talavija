<div class="user-widget-nav mx-auto">
    <a id="popoverTrigger" class="user-image hidden-xs" data-popover-content="#popoverContent" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="">
        <?php $user = Sentinel::getUser() ?>
        <img src="/storage/avatars/{{md5($user->member_id)}}.png" onerror="this.src='{{asset('img/profile-placeholder.jpg')}}'">
    </a>
</div>

<div style="display: none;" id="popoverContent">
    <div class="user-data">
        <?php $user = Sentinel::getUser() ?>
        <div><strong>{{$user->name}}</strong> {{$user->surname}}</div>
        <div>{{$user->email}}</div>
        <div>balance</div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $("#popoverTrigger").popover({
            html : true,
            content: function() {
                var content = $(this).attr("data-popover-content");
                return $(content).html();
            }
        });
    });
</script>