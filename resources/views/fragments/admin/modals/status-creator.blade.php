<div class="modal fade show" id="addStatusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Pievienot jaunu statusu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('shared.validation-errors')
                <form method="POST" action="{{$actionurl}}" id="addStatusForm">
                    {{csrf_field()}}
                    @include('shared.validation-errors')
                    <div class="form-group row">
                        <label for="status-title" class="col-sm-2 col-form-label required">Nosaukums</label>
                        <div class="col-sm-10">
                            <input type="text" required class="form-control" id="status-title" name="status-title">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status-abbr" class="col-sm-2 col-form-label required">Saīsinājums</label>
                        <div class="col-sm-10">
                            <input type="text" required class="form-control" id="status-abbr" name="status-abbr">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" id="submitResidence" class="btn btn-primary">Saglabāt</button>
                        </div>
                    </div>

                </form>
            </div>

            <script type="text/javascript">
                $(document).ready(function(){
                    thisForm   =   $("#addStatusForm");
                    thisModal  =   $("#addStatusModal");
                    targetList   =   $("#List");
                    var statusEditBtn = $("#status-list-btn");

                    thisModal.modal('show');

                    thisForm.on('submit', function (e) {
                        e.preventDefault();

                        var name = $("#role-name").val();
                        var slug = $("#role-abbr").val();


                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            url: thisForm.attr('action'),
                            type: 'POST',
                            data: thisForm.serialize(),
                            success: function( msg ) {
                                thisModal.modal('hide');
                                // dataLoader(targetList,'/admin/statuses/list');
                                statusEditBtn.click();
                            },
                            error: function (xhr, status, error) {

                            }
                        });
                    });
                })
            </script>
        </div>
    </div>
</div>
