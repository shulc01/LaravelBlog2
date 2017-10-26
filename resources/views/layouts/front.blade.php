@extends('layouts.site')

@section('content')

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

        <div class="navbar-nav-scroll">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('Admin') }}" target="_blank" >Admin</a>
                </li>
                <li><a href = "{{ route('ShowAllCategories') }}" target="_blank">All categories</a>
                    <ul class = "submenu">

                        {{--{!! strip_tags($allCategories, '<a><h><br/><li>') !!}--}}
                    
                    </ul>
                </li>
                <li>
                    <a href = "{{ route('ShowAllArticles') }}" target="_blank">All articles</a>
                </li>
            </ul>
        </div>

    <div class = "sidebar">

        <div class = "content-sidebar">

            <div id='kurs-com-ua-informer-main-ukraine-300x130-blue-container'>
                    <a href="//old.kurs.com.ua/informer" id="kurs-com-ua-informer-main-ukraine-300x130-blue" title="Курс валют информер Украина" rel="nofollow" target="_blank">Информер курса валют</a>
            </div>

            <script type='text/javascript'>
            (function() {var iframe = '<ifr'+'ame src="//old.kurs.com.ua/informer/inf2?color=blue" width="300" height="130" frameborder="0" vspace="0" scrolling="no" hspace="0"></ifr'+'ame>';var container = document.getElementById('kurs-com-ua-informer-main-ukraine-300x130-blue');container.parentNode.innerHTML = iframe;})();
            </script>
            <noscript><img src='//old.kurs.com.ua/static/images/informer/kurs.png' width='52' height='26' alt='kurs.com.ua: курс валют в Украине!' title='Курс валют' border='0' /></noscript>

            <br/>

            <div class="weather">

            <a target="_blank" href="http://nochi.com/weather/kharkiv-19227"><img src="https://w.bookcdn.com/weather/picture/4_19227_1_20_137AE9_160_ffffff_333333_08488D_1_ffffff_333333_0_6.png?scode=124&domid=589&anc_id=16899"  alt="booked.net"/></a>

            </div>

            <div class="last_news">

                <h2 style = "text-align: center;"><em>LAST NEWS</em></h2>

                @foreach ($lastArticles as $lastArticle)
               
                    <a style = "text-decoration: none;" href = "{{ route('ShowArticle', $lastArticle->id) }}"><b><h3 style = "text-align: center;">{{ $lastArticle->title }}</h3></b></a>
                    <h6 style = "text-align: center;">{{ $lastArticle->updated_at }}</h6>

                @endforeach

            </div>
        </div>

    </div>

    @yield('content2')

@endsection