<div class="card">
    <div class="card-body">
        @foreach($news as $key=>$newsPost)
            @include('fragments.news-individual', compact(['newsPost']))
        @endforeach
    </div>
</div>