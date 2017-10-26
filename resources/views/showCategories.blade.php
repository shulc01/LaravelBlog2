@extends ('layouts.front')

@section('content2')

    <div class = "cat">

    	<h2 class = "cat_title">All categories</h2>

        <ul>
            {!! $allCategories !!}
        </ul>

    </div>
    
@endsection