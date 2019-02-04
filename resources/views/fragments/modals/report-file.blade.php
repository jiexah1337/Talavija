<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="modal fade show" id="editProfilePictureModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLongTitle">Profilaa Bilde</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="fade show active">
                    <div>
                        @include('shared.validation-errors')
                        <div class="">
                            <img id="imagePreview" style="max-width: 100%; margin-left: auto; margin-right: auto; display: block;"
                                 src="/storage/avatars/{{md5($member_id)}}.png"
                                 onerror="this.src='{{asset('img/profile-placeholder.jpg')}}'">
                        </div>

                        <form method="POST" action="{{$actionurl}}" id="editProfilePictureForm">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <input type="file" name="image" class="form-control" id="image">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" id="submitBio" class="btn btn-primary">Saglabāt</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script src="{{asset('js/cropper.js')}}"></script>
            <link rel="stylesheet" href="{{asset('js/cropper.css')}}">
            <script src="{{asset('js/jquery-cropper.js')}}"></script>

            <script type="text/javascript">
                $(document).ready(function(){
                    $.fn.cropper();

                    BaseForm         =   $("#editProfilePictureForm");
                    BaseModal        =   $("#editProfilePictureModal");
                    BaseArea         =   $("#ProfilePictureArea");
                    var cropper = null;

                    BaseModal.modal('show');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $('#imagePreview').attr('src', e.target.result);
                                $("#imagePreview").cropper({
                                    aspectRatio: 1/1,
                                    zoomOnWheel: false,
                                    crop: function(event) {}
                                });

                                cropper = $("#imagePreview").data('cropper');

                                cropper.replace(e.target.result);
                            };
                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    $("#image").on('change',function(){
                        readURL(this);
                    });

                    BaseForm.on('submit', function (e) {
                        e.preventDefault();
                        cropper = $("#imagePreview").data('cropper');
                        var dab = new FormData();
                        dab.append('image',$('#image')[0].files[0]);
                        dab.append('crop', JSON.stringify(cropper.getData(true)));
                        $.ajax({
                            url: BaseForm.attr('action'),
                            type: 'POST',
                            data: dab,
                            processData: false,
                            contentType: false,
                            cache: false,
                            success: function( data ) {
                                BaseModal.modal('hide');
                                d = new Date();
                                $('#ProfilePictureArea img:first').attr("src",'/storage/avatars/'+data.imgHash+'.png?'+d.getTime());
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
