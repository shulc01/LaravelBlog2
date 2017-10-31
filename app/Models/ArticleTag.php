<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model
{

    public $table = 'article_tag';
    public $timestamps = false;

    protected $fillable = ['article_id', 'tag_id'];

}
