@php

    function drawCategoriesTree($listCategories, $parent_id, $level)
    {

        if (isset($listCategories[$parent_id])) {

            foreach ($listCategories[$parent_id] as $value) {

                echo  '<li><a href = /category/' . $value[0] . ' ><h' . ($level + 2) .'>';

            for ($i = 0; $i <= $level; $i++) {

                echo '- ';

            }

            echo $value[1] . '</h' . ($level + 2) .'></a></li>';

            $level++;

            drawCategoriesTree($listCategories, $value[0], $level);

            $level--;

            }
        }
    }

@endphp