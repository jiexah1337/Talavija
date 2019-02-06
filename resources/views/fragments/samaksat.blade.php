
    <head>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
        <title>Upload file</title>
    </head>

    <main role="main" class="ml-sm-auto col-md-10 pt-3">
        <br>
        <form method="POST" action="{{URL::to('money/store')}}" enctype="multipart/form-data" id="editProfilePictureForm">
            {{csrf_field()}}
            <div class="col-sm-6">
                <label for="xml"> Augsupieladet atskaiti</label>
                <input type="file" name="xml" class="form-control" id="image">
            <br>
                <button type="submit" name="button" id="submit" class="btn btn-primary">Saglabāt</button>
            </div>
        </form>
            <br>

        </form >
    </main>

