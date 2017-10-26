@extends ('layouts.front')

@section('content2')

<div class = "main">

    <h1 class = "cat_title">{{ ($categoryName ?? 'All') . ' News' }}</h1>

    @if (collect($articles)->isNotEmpty())

            @foreach ($articles as $article)

                @if (substr($article->image, 0, 4) == 'http') 

                        <div align = "center" style ="float: left; margin: 10px 0px 0px 50px;"><img align = "center" src = '{{ $article->image }}' 
                            width = "100" height = "100" border = "2" />
                        </div>

                @else
            
                    <div align = "center" style ="float: left; margin: 10px 0px 0px 50px;"><img align = "center" src = '{{ asset("/storage/images/". "$article->image") }}'
                        alt = "no image" width = "100" height = "100" border = "2"/>
                    </div>

                @endif

                <div style = "margin-left: 185px;">

                    <a href = "{{ route('ShowArticle', $article->id) }}" ><h2>{{ $article->title }}</h2></a>

                    <h4> {{ $article->description }} </h4>

                    <em><h5>{{ $article->updated_at }}</h5></em>

                </div>

                <hr/>

            @endforeach

    @else

        <h2>{{ 'Sorry, there are no articles in this category:-(' }}</h2>

    @endif

</div>    

@endsection