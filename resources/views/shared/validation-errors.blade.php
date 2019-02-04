@if (count($errors))
    <div class="form-group">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Please check your data!</h4>
            @foreach ($errors->all() as $error)
                <hr>
                <p class="mb-0">
                    {{ $error }}
                </p>
            @endforeach
        </div>
    </div>
@endif