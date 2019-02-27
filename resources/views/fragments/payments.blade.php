
@extends('layouts.master')

@section('content')
    @include('shared.nav')
    @if(isset($variabl))
        <head>
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <link rel="stylesheet" href="/resources/demos/style.css">
            <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

            <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

        </head>
        <main role="main" class="ml-sm-auto col-md-10 pt-3" xmlns:display="http://www.w3.org/1999/xhtml">

            <table class="table table-striped table-hover table-sm text-center">
                <thead class="thead-dark">
                <tr>

                    <th>Veikt</th>
                    <th>Vārds</th>
                    <th>Uzvārds</th>
                    <th>Summa</th>
                    <th>Datums</th>
                    <th>Merkis</th>
                    <th>Lietotajs</th>
                </tr>


                <tbody class="">
                <form action="{{route('payments')}}" method="post" role="form">
                @foreach($variabl['array'] as $key=>$id)

                        {{ csrf_field() }}
                        <tbody>
                <tr>

                    <td  class="Veikt">
                        <input type="checkbox" id="checkBox___{{$key}}" name="checkbox[]" id="{{$key+1/1024}}" value="{{$key}}" checked onclick="deactivate(this,{{$key}})" />
                    </td>
                    {{--<script>--}}
                        {{--function postfunc(id){--}}
                            {{--if(document.getElementById(id+1/1024).value != 1){--}}
                                {{--document.getElementById(id+2/1024).value=0;--}}
                            {{--}--}}
                        {{--}--}}

                    {{--</script>--}}
                    <input type="hidden" name="unique_id[]"  value="{{$id['Number']}}"  />

                    <td class="Vārds">

                        {{$id['Name_Lastname'][0]}}
                    </td>
                    <td class="Uzvārds">
                        {{$id['Name_Lastname'][1]}}
                    </td>
                    <td class="Summa">
                        <input name="Amount[]" value="{{$id['Amount']}}" type="hidden"/>
                        {{$id['Amount']}}{{$id['Currency']}}
                    </td>
                    <td class="Datums">
                        <input name="Date[]" value="{{$id['Date']}}" type="hidden"/>

                        {{$id['Date']}}
                    </td>
                        <td class="Merkis">
                        {{$id['Merkis']}}
                    </td>

                    <td class="Lietotajs">
                        <div class="form-group">
                            @if(isset($id['member_id']))
                                <input id="Lietotajs___{{$key}}" name="Lietotajs[{{$key}}]" list="select___{{$key}}"
                                       oninput="search(this,{{$key}})"
                                   value="{{$id['Name_Lastname'][0]}} {{$id['Name_Lastname'][1]}} ({{$id['member_id']}})"
                                       type="text" style="background-color : orange;"/>

                                @else
                            <input id="Lietotajs___{{$key}}" name="Lietotajs[{{$key}}]" list="select___{{$key}}"
                                   oninput="search(this,{{$key}})" value=""  type="text"  style=" background-color : red;"/>
                                <datalist id="select___{{$key}}">
                                </datalist>
                            @endif
                        </div>
                    </td>

                </tr>


                <script type="text/javascript">

                    function deactivate(checkBox,id){
                        lietotajs=document.getElementById("Lietotajs___"+id);
                        color=document.getElementById('color___'+id);

                        console.log(lietotajs.style.backgroundColor);
                        if (checkBox.checked == false){
                            if(lietotajs.style.backgroundColor == 'rgb(0, 255, 0)')
                                lietotajs.style.backgroundColor='#ffff00';

                        }else{
                            console.log("current color = "+lietotajs.style.backgroundColor);
                            if(lietotajs.style.backgroundColor == 'rgb(255, 255, 0)')
                                lietotajs.style.backgroundColor = '#00ff00';


                        }
                    }
                    function search(lietotajs,id){
                        vards=lietotajs.value;
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "GET",
                            url: '/money/RepForGroups/search',
                            data: { "vards": vards },
                            success: function (data){
                                // console.log(data);
                                var select = document.getElementById("select___"+id);
                                //Notirit datalistu kad nav rezultatu
                                if(data!=false){
                                select.innerHTML="";
                                }
                                for(var i = 0; i < data.length; i++) {
                                    var opt = data[i]['name'] +" "+data[i]['lastname']+" ("+data[i]['member_id']+")";
                                    var el = document.createElement("option");
                                    el.textContent = opt;
                                    el.value = opt;
                                    select.appendChild(el);
                                }
                                changecolor(lietotajs,id);

                            },
                            error: function (req, status, error){
                                changecolor(lietotajs,id);
                            }
                        });

                    }
                    $selectOption = $_POST['Select[]'];
                    function changecolor(lietotajs, id) {
                        colorinput = document.getElementById("color___" + id);
                        opt = document.getElementById("select___" + id);
                        checkBox = document.getElementById("checkBox___" + id)
                        for (var i = 0; opt.options.length; i++) {
                            if (opt.options[i].value == lietotajs.value && checkBox.checked == true) {
                                lietotajs.style.backgroundColor = '#00FF00';
                                i = opt.options.length;
                            } else {
                                if (opt.options[i].value == lietotajs.value) {
                                    lietotajs.style.backgroundColor = '#ffff00';
                                    i = opt.options.length;//break

                                }else{
                                    lietotajs.style.backgroundColor = '#FF0100';
                                }
                            }
                        }
                    }


                </script>

                @endforeach

                     <script>
                    function myFunctionss(source){

                        checkboxes = document.getElementsByName('checkbox[]');
                        for(var i=0, n=checkboxes.length;i<n;i++) {
                            checkboxes[i].checked = source.checked;
                        }
                    }
                </script>
                </tbody>



            </table>
            <label for="checkbox" > Select all </label>
            <input type="checkbox" id="checkbox" onclick="myFunctionss(this)">
            <br>
            <button class="btn btn-primary" type="submit">
                Submit
            </button>

            </form>
            <a href="/money/add" class="btn btn-primary">Atpakal</a>

        </main>

    @endif

@endsection