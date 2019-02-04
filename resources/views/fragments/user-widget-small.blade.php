<div class="user-widget user-widget-small <?php if(isset($deceased) && $deceased == true): ?> user-deceased <?php endif; ?> ">
    <?php if(isset($canUpdate) && $canUpdate == true): ?>
    <a href="#" data-editable-type="users/img" data-editable="{{$bio->member_id}}"
       data-toggle="tooltip" title="Rediģēt" class="edit-btn">
    <?php endif; ?>
        <div class="user-image">
            <img src="/storage/avatars/{{md5($bio->member_id)}}.png" onerror="this.src='{{asset('img/profile-placeholder.jpg')}}'">
        </div>
    <?php if(isset($canUpdate) && $canUpdate == true): ?>
    </a>
    <?php endif; ?>

</div>