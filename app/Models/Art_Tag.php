<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Art_Tag extends Model
{
    protected $fillable = ['article_id', 'tag_id'];

    public $table = 'article_tag';

    public $timestamps = false;

}
