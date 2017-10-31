<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>LaravelTest</title>
            <link rel="stylesheet" href="https://1maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <link rel="stylesheet" href = "{{asset('css/app.css')}}">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        </head>

        <body>

            @if(count($errors) > 0)

                <div class = "alert alert-danger">
                    <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

                    </ul>
                </div>

            @endif

            @yield('content')

        </body>
    </html>