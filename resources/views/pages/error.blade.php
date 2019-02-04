@extends('layouts.master')

@section('content')
    <main role="main" class="col-md-12">
        <div class="card">
            <div class="card-header bg-danger text-dark text-center">
                <h2>
                    <i class="fas fa-exclamation-triangle"></i>
                        {{$title}}
                    <i class="fas fa-exclamation-triangle"></i>
                </h2>
            </div>
            <div class="card-body bg-dark text-light text-center">
                <p>{{$content}}</p>
            </div>
        </div>
    </main>
@endsection