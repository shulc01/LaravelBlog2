@extends('layouts.site')

@section('content')

            <div>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('Admin') }}" target="_blank" >Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('CreateArticle') }}" target="_blank" >Add Article</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('CreateCategory') }}" target="_blank" >Add category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ShowAllArticles') }}" target="_blank" >Go to site</a>
                    </li>
                </ul>
            </div>

@yield('admin-content')

@endsection



