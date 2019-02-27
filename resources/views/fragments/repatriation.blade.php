{{--<div class="card">--}}
    {{--<div class="card-header">--}}
        {{--<span class="float-left">--}}
            {{--{{$rep->title}}--}}
        {{--</span>--}}
        {{--<span class="float-right">--}}
            {{--<a href="#" data-editable-type="money" data-editable="{{$rep->id}}"--}}
               {{--class="float-right delete-btn text-danger" data-toggle="tooltip" title="Dzēst">--}}
                {{--<i class="fas fa-minus-square"></i>--}}
            {{--</a>--}}

            {{--<a href="#" data-editable-type="money" data-editable="{{$rep->id}}"--}}
               {{--class="float-left edit-re-btn text-warning" data-toggle="tooltip" title="Rediģēt">--}}
                {{--<i class="fas fa-pen-square"></i>--}}
            {{--</a>--}}
        {{--</span>--}}
    {{--</div>--}}
    {{--<div class="card-body">--}}
        {{--<div>--}}
            {{--{{$rep->type}}--}}

        {{--</div>--}}
        {{--<div>--}}
            {{--Maksājums ievietots:--}}
            {{--@if($rep->issue_date())--}}
                {{--{{$rep->issue_date()}}--}}
            {{--@else--}}
                {{-----}}
            {{--@endif--}}
        {{--</div>--}}
        {{--<div>--}}
            {{--Summa: &euro; {{number_format($rep->amount,2,',',' ')}}--}}
        {{--</div>--}}
        {{--<div>--}}
            {{--Maksājums saņemts:--}}

            {{--@if($rep->paid_date())--}}
                {{--{{$rep->paid_date()}}--}}
            {{--@else--}}
                {{-----}}
            {{--@endif--}}
        {{--</div>--}}
        {{--<div>--}}
            {{--Saņemts: &euro; {{number_format($rep->collected,2,',',' ')}}--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<div class="card">
    <div class="card-body">
        <div>
            {{$rep->type}}

        </div>
        <div>
            @if($rep->amount <0)
            Apmaksat: &euro; {{number_format($rep->amount * -1,2,',',' ')}}

            @else
            Sanemts : &euro; {{number_format($rep->amount,2,',',' ')}}
            @endif
        </div>
        <div>
            Maksājums saņemts:

            @if($rep->issue_date())
                {{$rep->issue_date()}}
            @else
                -
            @endif
        </div>
    </div>
</div>