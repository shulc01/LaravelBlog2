<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public $timestamps = false;

    protected $fillable = ['name', 'description', 'parent_id'];

    public function articles()
    {

        return $this->hasMany('App\Models\Article');

    }

    public static function drawCategoriesTree($listCategories, $parent_id, $level)
    {

        if (isset($listCategories[$parent_id])) {

            foreach ($listCategories[$parent_id] as $value) {

                echo '<li><a href = /category/' . $value[0] . ' ><h' . ($level + 2) . '>';

                for ($i = 0; $i <= $level; $i++) {

                    echo '- ';

                }

                echo $value[1] . '</h' . ($level + 2) . '></a></li>';

                $level++;

                self::drawCategoriesTree($listCategories, $value[0], $level);

                $level--;

            }
        }
    }

}
