<div>
    @foreach($statuses as $status)
        <div class="info-line">
            <div class="pull-left">
                {{$status->title}}
            </div>

            <div class="pull-right">
                {{$status->abbreviation}}
            </div>
        </div>
    @endforeach
</div>