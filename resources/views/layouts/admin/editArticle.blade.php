@extends ('layouts.admin')

@section('admin-content')

@include('layouts.admin.adminTree')

<h2 class = "cat_title">Edit Article</h2>

    <div class = "admin">

        <form action = "{{ route('UpdateArticle') }}" enctype="multipart/form-data" method = "POST">

            <b>Title*</b><br/>

                <input class = "input-mini " size = "100" type="text" name="title" value="{{ $article->title }}" /><br/><br/>

            <b>Description*</b><br/>

                <input type="text" size = "100" name="description" value="{{ $article->description }}" /><br/><br/>

            <b>Text*</b><br/>

                <textarea name = "text" rows = "4" cols = "77">{{ $article->text }}</textarea><br/><br/>

            <b>Main foto*</b><br/>

                <input type = "file" accept="image" name = "image" /><br/><br/>

            @if (!empty($article->image))

                @if (substr($article->image, 0, 4) == 'http')

                    <a href = "{{ route('DeleteMainFotoArticle', [$article->image,  $article->id]) }}" onclick = "return confirm('Are you sure want to delete image {{ $article->image }}?') ? true : false;" >X</a>

                    <img src = '{{ $article->image }}' alt = "{{ $article->image }}" width = "100" height = "100" border = "2"/><br/></br/>

                @else

                    <a href = "{{ route('DeleteMainFotoArticle', [$article->image,  $article->id]) }}" onclick = "return confirm('Are you sure want to delete image {{ $article->image }}?') ? true : false;" >X</a>

                    <img src = '{{ asset("/storage/images/". "$article->image") }}' alt = "{{ $article->image }}" width = "100" height = "100" border = "2"/><br/></br/>

                @endif

            @endif

            <b>Upload Images</b><br/>

            <input type = "file" multiple = "multiple" accept="image" name = "images[]"  /><br/><br/>

            @forelse ($article->images as $image)

                <a href = "{{ route('DeleteImagesArticle', [$image->id,  $article->id]) }}" onclick = "return confirm('Are you sure want to delete image {{ $image->name }}?') ? true : false;" >X</a>

                <img src = '{{ asset("/storage/images/". "$image->name") }}' alt = "{{  $image->name }}" width = "100" height = "100" border = "2"/>

            @empty

                <p>No images</p>

            @endforelse

            <br/><br/><b>Category*</b><br/>

            <select name = "category_id">

                {{ outTree($listCategories, 0, 0, $article->category->id) }}

            </select><br/><br/>

            <input type="hidden" name = "id" value = "{{ $article->id }}"/>

            <input type="hidden" name = "mainImage" value = "{{ $article->image }}"/>

            <input type = "submit" value = "Update"/>

            {{ csrf_field() }}

        </form>

    </div>

@endsection