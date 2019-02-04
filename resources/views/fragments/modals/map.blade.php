<div class="modal fade show" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Karte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tab-pane fade show active" id="mapTab" role="tabpanel" aria-labelledby="bio-tab">
                    <div>
                        <div style="width: 500px; height: 500px;">
                            {{--{!! Mapper::render() !!}--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                Modal  =   $("#mapModal");
                Modal.modal('show');
            })
        </script>
    </div>
</div>