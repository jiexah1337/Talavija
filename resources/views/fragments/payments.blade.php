
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
                <?php
                    $variables=$variabl['array'];

                ?>
                @foreach($variables as $key=>$id)
                    <form action="{{route('payments')}}" method="post" role="form">
                        {{ csrf_field() }}
                        <tbody>
                <tr>

                    <td  class="Veikt">
                        <input type="checkbox"  name="checkbox[]" id="{{$key+1/1024}}" value="{{$key}}" checked />
                    </td>
                    <script>
                        function postfunc(id){
                            if(document.getElementById(id+1/1024).value != 1){
                                document.getElementById(id+2/1024).value=0;
                            }
                        }

                    </script>
                    <input type="hidden" name="checksbox[]" id="{{$key+2/1024}}" value="1"  />

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
                        <select  name="Select[]" >
                            @if($id['member_id'] != null)
                                <option>{{$id['Name_Lastname'][0]}} {{$id['Name_Lastname'][1]}} ({{$id['member_id']}})</option>
                            @else
                                <option></option>
                            @foreach($variabl['users'] as $idd)
                                <option>{{$idd->name}}  {{$idd->surname}} ({{$idd->member_id}})</option>
                            @endforeach
                            @endif

                        </select>
                    </td>

                </tr>

                <script type="text/javascript">
                    $selectOption = $_POST['Select[]'];

                    $("#nameid").select2({
                        placeholder: "Select a Name",
                        allowClear: true
                    )};
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

        </main>

    @endif

@endsection