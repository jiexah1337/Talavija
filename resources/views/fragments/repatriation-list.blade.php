
@foreach($reps as $key=>$rep)
    @include('fragments.repatriation', $rep)
@endforeach

<script>
    $(document).ready(function(){
        editButtonOverride(".edit-re-btn", null);
        deleteButtonOverride(false);
    });
</script>