<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Art_Tag extends Model
{
    protected $fillable = ['article_id', 'tag_id'];

    public $table = 'article_tag';

    public $timestamps = false;

    /*public function category() {

    	// return $this->belongsTo('App\Models\Category');

    	return $this->belongsTo('App\Models\Category');

    }
*//*
    public function tags()
    {

    	return $this->belongsToMany('App\Models\Tag');

    }*/

    public function tags_articles() {

    	//return $this->belongsToMany('App\Models\Article', '', 'article_id', 'id');

    }
}
