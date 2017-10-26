@extends ('layouts.admin')

@section('admin-content')

    <h2 class = "cat_title">Edit Article</h2>

<div class = "admin">

    <form action = "{{ route('UpdateArticle') }}" enctype="multipart/form-data" method = "POST">

        <b>Title*</b><br/>

            <input class = "input-mini " size = "100" type="text" name="title" value="{{ $editArticle->title }}" /><br/><br/>

        <b>Description*</b><br/>

            <input type="text" size = "100" name="description" value="{{ $editArticle->description }}" /><br/><br/>

        <b>Text*</b><br/>

            <textarea name = "text" rows = "4" cols = "77">{{ $editArticle->text }}</textarea><br/><br/>

        <b>Main foto*</b><br/>

            <input type = "file" accept="image" name = "image" /><br/><br/>

        @if (!empty($editArticle->image)) 

            @if (substr($editArticle->image, 0, 4) == 'http')   

              <!--   <a href = "{{ route('DeleteMainFotoArticle', [$editArticle->image,  $editArticle->id]) }}" onclick = "return confirm('Are you sure want to delete image {{ $editArticle->image }}?') ? true : false;" >X</a> -->

                <img src = '{{ $editArticle->image }}' alt = "{{ $editArticle->image }}" width = "100" height = "100" border = "2"/><br/></br/>

            @else

                <a href = "{{ route('DeleteMainFotoArticle', [$editArticle->image,  $editArticle->id]) }}" onclick = "return confirm('Are you sure want to delete image {{ $editArticle->image }}?') ? true : false;" >X</a>

                <img src = '{{ asset("/storage/images/". "$editArticle->image") }}' alt = "{{ $editArticle->image }}" width = "100" height = "100" border = "2"/><br/></br/>

            @endif
          
        @endif

        <b>Upload Images</b><br/>

            <input type = "file" multiple = "multiple" accept="image" name = "images[]"  /><br/><br/>

            @forelse ($imagesEditArticle as $imageEditArticle)

                <a href = "{{ route('DeleteImagesArticle', [$imageEditArticle->id,  $editArticle->id]) }}" onclick = "return confirm('Are you sure want to delete image {{ $imageEditArticle->name }}?') ? true : false;" >X</a>

                <img src = '{{ asset("/storage/images/". "$imageEditArticle->name") }}' alt = "{{ $imageEditArticle->name }}" width = "100" height = "100" border = "2"/>

            @empty

                <p>No images</p>

            @endforelse

        <br/><br/>

        <b>Category*</b><br/>

        <select name = "category_id">

            {!! $optionCategories !!}

        </select><br/><br/>

        <input type="hidden" name = "id" value = "{{ $editArticle->id }}"/>

        <input type="hidden" name = "mainImage" value = "{{ $editArticle->image }}"/>

        <input type = "submit" value = "Update"/>

        {{ csrf_field() }}

    </form>

</div>

@endsection