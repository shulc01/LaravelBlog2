<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article_Image extends Model
{

    public $table = 'article_image';
    public $timestamps = false;

    protected $fillable = ['article_id', 'image_id'];

}
