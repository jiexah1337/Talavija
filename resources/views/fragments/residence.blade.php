<div class="card">
    <div class="card-header">
        <a href="#" class="map-btn" data-location="{{$residence->location->id}}">
            <strong class="float-left">{{$residence->location->address}}</strong>
        </a>

        <span class="float-right">
            <?php if($canUpdate): ?>
            <a href="#" data-editable-type="residence" data-editable="{{$residence->id}}"
               class="float-left edit-btn text-warning" data-toggle="tooltip" title="Rediģēt">
                <i class="fas fa-pen-square"></i>
            </a>
            <a href="#" data-editable-type="residence" data-editable="{{$residence->id}}"
               class="float-right delete-btn text-danger" data-toggle="tooltip" title="Dzēst">
                <i class="fas fa-minus-square"></i>
            </a>
            <?php endif ?>
        </span>
    </div>
    <div class="card-body">
        <div class="info-line">
            <span>
                <strong>Valsts: </strong>
            </span>
            <span>
                {{$residence->location->country or '-'}}
            </span>
        </div>
        <div class="info-line">
            <span>
                <strong>Pilsēta: </strong>
            </span>
            <span>
                {{$residence->location->city or '-'}}
            </span>
        </div>
        <div class="info-line">
            <span>
                <strong>Adrese: </strong>
            </span>
            <span>
                {{$residence->location->address or '-'}}
            </span>
        </div>
        <div class="info-line">
            <span>
                <strong>Piezīmes: </strong>
            </span>
            <span>
                {{$residence->location->notes or '-'}}
            </span>
        </div>
        <div class="bg-secondary text-center">
            <div>
                <strong>
                    Laiks:
                </strong>
            </div>
        </div>
        <div class="info-line">
            <span>
                {{$residence->start_date()}}
            </span>
            <span>
                -
            </span>
            <span>
                @if(null != $residence->end_date())
                {{$residence->end_date()}}
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