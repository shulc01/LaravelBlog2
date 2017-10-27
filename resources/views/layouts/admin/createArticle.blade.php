@extends ('layouts.admin')

@section('admin-content')

    @include('layouts.admin.adminTree')

    <h2 class = "cat_title">Create Article</h2>

<div class = "admin">

    <form action = "{{ route('StoreArticle') }}" enctype="multipart/form-data" method = "POST">

        <b>Title*</b><br/>
            
            <input class = "input-mini " size = "100" type="text" name="title" /><br/><br/>

        <b>Description*</b><br/>

            <input type="text" size = "100" name="description" /><br/><br/>

        <b>Text*</b><br/>

            <textarea name = "text" rows = "4" cols = "77"></textarea><br/><br/>

        <b>Main foto*</b><br/>

            <input type = "file" accept="image" name = "image" required /><br/><br/>

        <b>Upload Images</b><br/>

            <input type = "file" multiple = "multiple" accept="image" name = "images[]" /><br/><br/>

        <b>Category*</b><br/>

        <select name = "category_id">

            {{ outTree($listCategories, 0, 0) }}

        </select><br/><br/>

        <input type = "submit" value = "Save"/>

        {{ csrf_field() }}

    </form>

</div>

@endsection