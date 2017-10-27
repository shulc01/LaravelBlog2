
@php

    function drawCategoriesTree($listCategories, $parent_id, $level, $categoryId = false)
    {

        if (isset($listCategories[$parent_id])) {

            foreach ($listCategories[$parent_id] as $value) {

                echo  '<option value = ' . $value[0];

                if ($value[0] == $categoryId) {

                    echo  ' selected ';

                }

                echo '>';

                for ($i = 0; $i <= $level; $i++) {  //?????

                    echo ' - ';
                }

                echo $value[1]. '</option>';

                $level++;

                drawCategoriesTree($listCategories, $value[0], $level, $categoryId);

                $level--;

            }
        }
    }

@endphp