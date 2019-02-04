@foreach($studies['active'] as $study)
    @include('fragments.study', array('study' => $study, 'canUpdate' => $canUpdate))
@endforeach

@if(count($studies['inactive']) > 0)
<div class="card collapse-btn">
    <a href="#" data-toggle="collapse" data-target="#inactiveStudies" class="collapsed text-primary">
        <div class="card-header bg-light text-center">

            <span class="if-not-collapsed">
                <i class="fas fa-angle-double-up"></i>
            </span>
            <span class="if-collapsed">
                <i class="fas fa-angle-double-down"></i>
            </span>


        </div>
    </a>
</div>

<div id="inactiveStudies" class="inactive-style collapse">
    @foreach($studies['inactive'] as $study)
        @include('fragments.study', array('study' => $study, 'canUpdate' => $canUpdate))
    @endforeach
</div>
@endif

