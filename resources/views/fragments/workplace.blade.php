<div class="card">
    <div class="card-header">
        <strong class="float-left">{{$workplace->company}}</strong>
        <span class="float-right">
            <?php if($canUpdate): ?>
            <a href="#" data-editable-type="workplace" data-editable="{{$workplace->id}}"
               class="float-left edit-btn text-warning" data-toggle="tooltip" title="Rediģēt">
                <i class="fas fa-pen-square"></i>
            </a>
            <a href="#" data-editable-type="workplace" data-editable="{{$workplace->id}}"
               class="float-right delete-btn text-danger" data-toggle="tooltip" title="Dzēst">
                <i class="fas fa-minus-square"></i>
            </a>
            <?php endif ?>
        </span>
    </div>
    <div class="card-body">
        <div class="info-line">
            <span>
                <strong>Nozare: </strong>
            </span>
            <span>
                {{$workplace->field or '-'}}
            </span>
        </div>
        <div class="info-line">
            <span>
                <strong>Amats: </strong>
            </span>
            <span>
                {{$workplace->position or '-'}}
            </span>
        </div>
        <div class="info-line">
            <span>
                <strong>Sākuma datums: :</strong>
            </span>
            <span>
                @if(null != $workplace->start_date())
                    {{$workplace->start_date()}}
                @else
                    -
                @endif
            </span>
        </div>
        <div class="info-line">
            <span>
                <strong>Beigu datums: :</strong>
            </span>
            <span>
                @if(null != $workplace->start_date())
                    {{$workplace->start_date()}}
                @else
                    -
                @endif
            </span>
        </div>
        {{--<div class="info-line">--}}
            {{--<span>--}}
                {{--<strong>Strādāts :</strong>--}}
            {{--</span>--}}
            {{--<span>--}}
                {{--{{$workplace->span}}--}}
            {{--</span>--}}
        {{--</div>--}}
    </div>
</div>