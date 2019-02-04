@extends('layouts.single')

@section('center-content')
    <form class="form-signin bg-dark" method="POST" action="/activate/{{$userId}}/{{$activationCode}}">
        {{ csrf_field() }}
        <div class="form-center">
            <img class="mb-4" src="{{asset('img/Talavija 2.png')}}" alt="" width="200px" height="auto">
            <h1 class="h3 mb-3 font-weight-normal text-white">Ievadiet savu jauno paroli!</h1>
            @include('shared.validation-errors')

            <div class="text-light">
                <h4>
                    <b>
                        {{$user->name}}
                    </b>
                    {{$user->surname}}
                </h4>

            </div>
            <div class="text-light">{{$user->email}}</div>
            <hr>

            <label for="pwd" class="sr-only">Parole</label>
            <input type="password" required class="form-control" placeholder="Parole" id="pwd" name="pwd">

            <label for="pwd_confirmation" class="sr-only">Parole atkārtoti</label>
            <input type="password" required class="form-control" placeholder="Parole atkārtoti" id="pwd_confirmation" name="pwd_confirmation">

            <button class="btn btn-lg btn-primary btn-block" type="submit" id="submitBtn">Pierakstīties</button>
            <p class="mt-5 mb-3 text-muted">© 2017-2018</p>
        </div>
        <div id="validationBox">

        </div>
    </form>
    <script type="application/javascript">
        $(document).ready(function(){
            var cnfrmpwd = $("#pwd_confirmation");
            var newpwd = $("#pwd");
            var submitBtn = $("#submitBtn");
            $.each([cnfrmpwd, newpwd], function(index){
                $(this).on('change keyup', function(){
                    var pwdRegEx = new RegExp(/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/);

                    if(cnfrmpwd.val() !== newpwd.val() || !pwdRegEx.test(newpwd.val()) || newpwd.val().length <6){
                        cnfrmpwd.addClass('is-invalid');
                        newpwd.addClass('is-invalid');
                        submitBtn.prop("disabled", true);

                        if(newpwd.val().length <6){
                            $('#validationBox').html('Parole ir pārāk īsa! Ievadiet vismaz 6 simbolus!');
                            $('#validationBox').show();
                        } else if(!pwdRegEx.test(newpwd.val())){
                            $('#validationBox').html('Parole nav pietiekoši sarežģīta! Izmantojiet Ciparus, Lielos un mazos burtus kā arī simbolus!');
                            $('#validationBox').show();
                        } else if(cnfrmpwd.val() !== newpwd.val()){
                            $('#validationBox').html('Paroles nesakrīt!');
                            $('#validationBox').show();
                        }


                    } else {
                        cnfrmpwd.removeClass('is-invalid');
                        newpwd.removeClass('is-invalid');
                        submitBtn.prop("disabled", false);
                        $('#validationBox').hide();
                    }
                });
            });
        })
    </script>
@endsection