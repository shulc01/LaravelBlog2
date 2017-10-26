@extends ('layouts.front')

@section('content2')

<style>
    .sl_ctr{
    position:relative;
    width:450px;
    height:450px;
    overflow:hidden;
    margin-left: 485px;
    }
    .sldr{
    position:relative;
    width:10000px;
    height:300px;
    }
    .sldr img{
    float:left;
    }
    .prv_b, .nxt_b{
    position:absolute;
    top:135px;
    display:block;
    width:35px;
    height:35px;
    cursor:pointer;
    }
    .prv_b:hover, .nxt_b:hover{opacity:.9;}
    .prv_b{
    left:10px;
    background:url({{asset('css/imagesl.png')}}) no-repeat;
    }
    .nxt_b{
    right:10px;
    background:url( {{ asset('css/imagesr.jpg') }} ) no-repeat;
    }
</style>

<script>
    $(function() {
    var sldr = $('.sldr'),
    sldrContent = sldr.html(),
    slideWidth = $('.sl_ctr').outerWidth(),
    slideCount = $('.sldr img').length,
    prv_b = $('.prv_b'),
    nxt_b = $('.nxt_b'),
    sldrInterval = 1100,
    animateTime = 2000,
    course = 1,
    margin = - slideWidth;
    $('.sldr img:last').clone().prependTo('.sldr');$('.sldr img').eq(1).clone().appendTo('.sldr');$('.sldr').css('margin-left',-slideWidth);function nxt_bSlide(){interval=window.setInterval(animate,sldrInterval)}function animate(){if(margin==-slideCount*slideWidth-slideWidth){sldr.css({'marginLeft':-slideWidth});margin=-slideWidth*2}else if(margin==0&&course==-1){sldr.css({'marginLeft':-slideWidth*slideCount});margin=-slideWidth*slideCount+slideWidth}else{margin=margin-slideWidth*(course)}sldr.animate({'marginLeft':margin},animateTime)}function sldrStop(){window.clearInterval(interval)}prv_b.click(function(){if(sldr.is(':animated')){return false}var course2=course;course=-1;animate();course=course2});nxt_b.click(function(){if(sldr.is(':animated')){return false}var course2=course;course=1;animate();course=course2});sldr.add(nxt_b).add(prv_b).hover(function(){sldrStop()},nxt_bSlide);nxt_bSlide()});
</script>

<div class = "main">

        <h3 align = "right">Category: <a href = "{{ route('ShowArticlesFromCategory', $article->category->id) }}"> {{ $article->category->name }} </a></h3>
        <h2 align = "center"><em>{{  $article->title }}</em></h2>
        <h4 align = "center">{{ $article->description }}</h4>

        @if (substr($article->image, 0, 4) == 'http' && substr($article->text, 0, 4) != 'http') 

            <div align = "center"><img align = "center" src = '{{ $article->image }}' width = "300" height = "300" border = "1" /></div>
            <p align = "center">{!! $article->text !!}</p>

        @elseif (substr($article->image, 0, 4) == 'http' && substr($article->text, 0, 4) == 'http')

            <div align = "center"><img align = "center" src = '{{ $article->image }}' width = "300" height = "300" border = "1" /></div>
            <p align = "center"><a href = "{{ $article->text }}">Текст</a></p>

        @else 

            <div align = "center"><img align = "center" src = '{{ asset("/storage/images/". "$article->image") }}' width = "300" height = "300" border = "1" /></div>
            <p align = "center">{!! $article->text !!}</p>

        @endif

        @if (collect($article->images)->isNotEmpty())

            <div class="sl_ctr">
                <div class="sldr">

            @foreach($article->images as $articleImage)

                <img src = '{{ asset("/storage/images/". "$articleImage->name") }}' width = "450" height = "400" border = "2"/>

            @endforeach

                </div>
                <div class="prv_b"></div>
                <div class="nxt_b"></div>
            </div>

        @endif

</div>

@endsection