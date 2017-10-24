@extends ('layouts.admin')

@section('admin-content')

    <script>

        function confirmDelete()
        {

            var x = confirm("Are you sure want to delete this article?");

            if (x) return true;

            else return false;
        }

    </script>

    @if (isset(Auth::user()->name) && Auth::user()->name == 'admin')

        <div style="float: right;">
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

 <div class = "admin">

    <h2 class = "cat_title">ALL NEWS</h2>

        @foreach($allArticles as $article)

            <form action = "{{ route('DeleteArticle', $article->id) }}" method = "POST" onsubmit = "return confirmDelete()">

                <a href = "{{ route('EditArticle', $article->id) }}" target = "_blank">{{ $article->title }}</a>
                <a href = "{{ route('ShowArticlesFromCategory', $article->category_id) }}" target = "_blank">({{ $article->category->name }})</a>

                <input type="submit" value="X"/><br /><br />

                {{ method_field('DELETE') }}
                {{ csrf_field() }}

            </form>

        @endforeach

    @else

        <h1> YOU NO ADMIN!!! </h1>

 </div>

    <div style="float: right;">
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
