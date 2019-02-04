
@extends('layouts.master')

@section('content')
    @include('shared.nav')
    @if(isset($variables))
        <main role="main" class="ml-sm-auto col-md-10 pt-3">
            <table class="table table-striped table-hover table-sm text-center">
        <thead class="thead-dark">
        <tr>

            <th>Veikt</th>
            <th data-toggle="tooltip" data-placement="bottom" title="Biedra Nr.">#</th>
            <th>Vārds</th>
            <th>Uzvārds</th>
            <th>Summa</th>
            <th>Atlaide %</th>
        </tr>


        <tbody class="">

        @foreach($variables as $key=>$id)

        <form action="{{route('create.store')}}" method="post" role="form">
                {{ csrf_field() }}
            <input type="hidden" name="title" value="{{$id['title']}}">
            <input type="hidden" name="reason" value="{{$id['reason']}}">
            <input type="hidden" name="start_date" value="{{$id['start_date']}}">
            <tbody>
            <tr>
                <td class="Veikt">
                    <input type="checkbox"  name="checkbox[]" id="{{$key+1/1024}}" value="{{$key}}" checked />

                    <script>
                        function postfunc(id){
                        if(document.getElementById(id+1/1024).value != 1){
                            document.getElementById(id+2/1024).value=0;
                        }
                        }

                    </script>
                    <input type="hidden" name="checksbox[]" id="{{$key+2/1024}}" value="1"  />

                </td>
                <script>

                </script>
                <td class="member_id">
                    <input type="hidden" name="member_id[]" value="{{$id['member_id']}}"/>
                    {{$id['member_id']}}
                </td>
                <td class="Vards">
                    {{$id['name']}}
                </td>
                <td class="Uzvards">
                    {{$id['lastname']}}
                </td>
                {{-- mes izmantojam $key ka indeksu, $key+1*35/64 lai summas
                un atlaizu id atskiras +1 jo var but 0 index un tad nevares atrast to inputu--}}
                <td class="Summa">
                    <input class="col-3" id={{$key}} name="Summa[]" value={{$id['Value']}} type="text" required="required">
                </td>
                <td class="Atlaides">
                    <input class="col-3" id={{$key+1*35/64}} name="Discount[]" value={{$id['discount']}} type="text" required="required" onchange="myFunction({{$key}})">
                    <script>
                        function myFunction( id ) {
                            var summa ="<?php echo $id['Value'] ?>";

                            var atlaide = document.getElementById(id+1*35/64).value;
                            document.getElementById(id).value= summa-summa*atlaide/100;
                        }
                    </script>

                </td>

            </tr>
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