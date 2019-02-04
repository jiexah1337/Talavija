<div class="card">
    <div class="card-header">
        <strong class="float-left">{{$study->name}}</strong>
        <span class="float-right">
            <?php if($canUpdate): ?>
            <a href="#" data-editable-type="study" data-editable="{{$study->id}}"
               class="float-left edit-btn text-warning" data-toggle="tooltip" title="Rediģēt">
                <i class="fas fa-pen-square"></i>
            </a>
            <a href="#" data-editable-type="study" data-editable="{{$study->id}}"
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
                {{$study->faculty or '-'}}
            </span>
        </div>
        <div class="info-line">
            <span>
                <strong>Programma: </strong>
            </span>
            <span>
                {{$study->program or '-'}}
            </span>
        </div>
        <div class="info-line">
            <span>
                <strong>Grāds: </strong>
            </span>
            <span>
                {{$study->degree or '-'}}
            </span>
        </div>
        <div class="info-line">
            <span>
                <strong>Absolvējis: </strong>
            </span>
            <span>
                {{$study->graduated == true ? 'Jā' : 'Nē'}}
            </span>
        </div>
        <div class="info-line">
            <span>
                <strong>Sākuma datums: :</strong>
            </span>
            <span>
                @if(null != $study->start_date())
                {{$study->start_date()}}
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
                @if(null != $study->end_date())
                    {{$study->end_date()}}
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