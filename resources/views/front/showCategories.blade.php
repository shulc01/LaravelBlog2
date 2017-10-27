@extends ('layouts.front')

@section('content2')

    <div class = "cat">

    	<h2 class = "cat_title">All categories</h2>

        <ul>

            {{ App\Models\Category::drawCategoriesTree($listCategories, 0, 0) }}

        </ul>

    </div>
    
@endsection