@extends ('layouts.front')

@section('content2')

    {{ dd(function_exists('outTree')) }}

    @include('layouts.front.frontTree')

    <div class = "cat">

    	<h2 class = "cat_title">All categories</h2>

        <ul>

            {{ outTree($listCategories, 0, 0) }}

        </ul>

    </div>
    
@endsection