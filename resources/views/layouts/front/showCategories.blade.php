@extends ('layouts.front')

@section('content2')

    @php

    function outTree($listCategories, $parent_id, $level)
    {

        if (isset($listCategories[$parent_id])) {

            foreach ($listCategories[$parent_id] as $value) {

                echo  '<li><a href = /category/' . $value[0] . ' ><h' . ($level + 2) .'>';

            for ($i = 0; $i <= $level; $i++) {

                echo '- ';

            }

            echo $value[1] . '</h' . ($level + 2) .'></a></li>';

            $level++;

            outTree($listCategories, $value[0], $level);

            $level--;

            }
        }
    }

    @endphp

    <div class = "cat">

    	<h2 class = "cat_title">All categories</h2>

        <ul>

            {{ outTree($listCategories, 0, 0) }}

        </ul>

    </div>
    
@endsection