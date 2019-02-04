@extends('layouts.single')

@section('center-content')
    <form class="form-signin bg-dark" method="POST" action="/login">
        {{ csrf_field() }}
        <div class="form-center">
            <img class="mb-4" src="{{asset('img/Talavija 2.png')}}" alt="" width="200px" height="auto">
            <h1 class="h3 mb-3 font-weight-normal text-white">Lūdzu pierakstieties</h1>
            @include('shared.validation-errors')
            <label for="inputEmail" class="sr-only">E-Pasts</label>
            <input id="inputEmail" class="form-control" name="email" placeholder="E-Pasts" required="" autofocus="" type="email">
            <label for="inputPassword" class="sr-only">Parole</label>
            <input id="inputPassword" class="form-control" name="password" placeholder="Parole" required="" type="password">
            <div class="checkbox mb-3">
                <label class="text-white">
                    <input value="remember-me" name="remember" type="checkbox"> Atcerēties mani
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Pierakstīties</button>
            <p class="mt-5 mb-3 text-muted">!!! IZSTRĀDES VERSIJA | DATI VAR PAZUST !!!</p>
            <p class="mt-5 mb-3 text-muted">© 2017-2018</p>
        </div>
    </form>
@endsection