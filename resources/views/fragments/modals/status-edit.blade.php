<div class="modal fade show" id="editStatusesModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Biedra Statuss</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('shared.validation-errors')
                <form method="POST" action="{{$actionurl}}" id="statusesForm">
                    {{csrf_field()}}

                    <div>
                        <select class="form-control" id="status-select" name="status-select">
                            @foreach($statuses as $key=>$status)
                                <option value="{{$status->id}}">({{$status->abbreviation}}) {{$status->title}}</option>
                            @endforeach
                        </select>
                    </div><br>

                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" id="submitUserRoles" class="btn btn-primary">Saglabāt</button>
                        </div>
                    </div>
                </form>
            </div>

            <script type="text/javascript">
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(document).ready(function(){
                    Form         =   $("#statusesForm");
                    Modal      =   $("#editStatusesModal");

                    Modal.modal('show');

                    Form.on('submit', function (e) {
                        e.preventDefault();

                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            url: Form.attr('action'),
                            type: 'POST',
                            data: Form.serialize(),
                            success: function( msg ) {
                                Modal.modal('hide');
                                $('#statusBtn').html(msg.html)
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
