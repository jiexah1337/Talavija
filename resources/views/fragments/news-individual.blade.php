<div class="card">
<?php
    $bgClass = '';
    $textClass = '';
    $accentIcon = '';
    $bgIconClass = '';
    switch($newsPost->type){
        case 'info':
            $bgClass = 'bg-info';
            $bgIconClass = 'text-info';
            $textClass = 'text-light';
            $accentIcon = '<i class="fas fa-info-circle"></i>';
            break;
        case 'warning':
            $bgClass = 'bg-warning';
            $bgIconClass = 'text-warning';
            $textClass = 'text-dark';
            $accentIcon = '<i class="fas fa-exclamation-circle"></i>';
            break;
        case 'danger':
            $bgClass = 'bg-danger';
            $bgIconClass = 'text-danger';
            $textClass = 'text-dark';
            $accentIcon = '<i class="fas fa-exclamation-triangle"></i>';
            break;
        case 'brand':
            $bgClass = 'bg-primary';
            $bgIconClass = 'text-primary';
            $textClass = 'text-light';
            $accentIcon = 'PAGE_BRAND';
            break;
        default:
            $bgClass = '';
            $textClass = '';
            $accentIcon = '';
            break;
    }
?>
    <div class="card-header {{$bgClass}} {{$textClass}} card-header-0p">
        <div class="row">
            <div class="col-1 d-none d-md-block">
                <div class="news-title-image">
                    <img src="/storage/avatars/{{md5($newsPost->user->member_id)}}.png"
                         onerror="this.src='{{asset('img/profile-placeholder.jpg')}}'">
                </div>
            </div>
            <div class="col-md-3 col-sm-12 card-header-restore-p text-center">
                <a href="/bio/{{$newsPost->member_id}}" class="{{$textClass}} ">
                    {{$newsPost->user->status()->abbreviation}}
                    <b>
                        {{$newsPost->user->name}}
                    </b>
                    {{$newsPost->user->surname}}
                     <i class="fas fa-link"></i>
                </a>

            </div>
            <div class="col-md-8 col-sm-12 text-center card-header-restore-p">
                <b>
                    <h5>
                        {{$newsPost->title}}
                    </h5>
                </b>
            </div>
        </div>

    </div>
    <div class="card-body news-card">
        <div class="news-box">
            <div class="large-icon-bg {{$bgIconClass}}">
                @if($accentIcon !== 'PAGE_BRAND')
                {!! $accentIcon !!}
                @else
                    <img src="{{asset('img/Talavija 2.png')}}"/>
                @endif
            </div>
            <div class="large-icon-content">
                {!! $newsPost->content !!}
            </div>
        </div>
    </div>
    <div class="card-footer text-right">
        {{$newsPost->post_date->format('d/m/Y H:i')}}
    </div>
</div>