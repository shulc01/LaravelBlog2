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

    @if (isset(Auth::user()->name) && Auth::user()->name == 'admin')

        @yield('admin-content')

    @else

        <h1> YOU NO ADMIN!!! </h1>

            <div style="float: left;">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endguest
                </ul>
            </div>

    @endif

@endsection



