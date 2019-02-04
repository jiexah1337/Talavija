<div class="modal fade show" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">

                <h5 class="modal-title" id="exampleModalLongTitle">Apstipriniet darbību</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body bg-dark">

                <div class="tab-pane fade show active" id="residenceTab" role="tabpanel" aria-labelledby="residence-tab">
                    <div>
                        @include('shared.validation-errors')
                        <form method="POST" action="{{$actionurl}}" id="confirmForm">
                            {{csrf_field()}}
                            <input type="hidden" id="member_id" readonly value="{{$memberid}}" name="member_id">
                            <div class="form-group">
                                {!! $partial !!}
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4"></div>
                                <div role="group" class="col-md-4 btn-group-justified">
                                    <button type="submit" id="submit" class="btn btn-dark btn-">Apstiprināt</button>
                                    <button type="button" id="cancel" class="btn btn-dark">Atcelt</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <script type="text/javascript">
                $(document).ready(function(){
                    confirmForm   =   $("#confirmForm");
                    confirmModal  =   $("#confirmModal");
                    residenceList =   $("#residenceList");
                    studyList     =   $("#studyList");
                    workplaceList =   $("#workplaceList");

                    confirmModal.modal('show');

                    confirmForm.on('submit', function (e) {
                        e.preventDefault();
                        $.ajax({
                            url: $('#confirmForm').attr('action'),
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function( msg ) {
                                confirmModal.modal('hide');
                                dataLoader(residenceList,   '/residence/index/'+$('#member_id').val());
                                dataLoader(studyList,       '/study/index/'+$('#member_id').val());
                                dataLoader(workplaceList,   '/workplace/index/'+$('#member_id').val());
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
