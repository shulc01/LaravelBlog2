@extends ('layouts.admin')

@section('admin-content')

	@include('admin.adminTree')

	<h1 class = "cat_title">Create category</h1>

	<div class = "admin">

	    <form action = "{{ route('SaveCategory') }}" method = "POST">

	        <br/><b>Title*</b><br/>

	        	<input class = "input-mini" size = "100" type="text" name="name"/><br/><br/>

	        <b>Description*</b><br/>

	        	<textarea name = "description" rows = "4" cols = "77"></textarea><br/><br/>

	        <b>Parent category*</b><br/>

	        	<select name = "parent_id">

					{{ drawCategoriesTree($listCategories, 0, 0) }}

				</select><br/><br/>

	        <input type = "submit" value = "Save"/>

	        {{ csrf_field() }}

	    </form>

    </div>

@endsection