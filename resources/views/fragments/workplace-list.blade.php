<div>
    @foreach($workplaces['active'] as $workplace)
        @include('fragments.workplace', array('workplace' => $workplace, 'canUpdate' => $canUpdate))
    @endforeach
</div>

@if(count($workplaces['inactive']) > 0)
<div class="card collapse-btn">
    <a href="#" data-toggle="collapse" data-target="#inactiveWorkplaces" class="collapsed text-primary">
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
@endif

<div id="inactiveWorkplaces" class="inactive-style collapse">
    @foreach($workplaces['inactive'] as $workplace)
        @include('fragments.workplace', array('workplace' => $workplace, 'canUpdate' => $canUpdate))
    @endforeach
</div>

