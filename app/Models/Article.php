<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'description', 'text', 'image', 'category_id', 'content', 'created_at', 'updated_at'];
    protected $casts = [
        'content' => 'json'
    ];

    public function category() {

    	return $this->belongsTo('App\Models\Category');
    }

    public function tags()
    {

    	return $this->belongsToMany('App\Models\Tag');
    }

    public function images() {

    	return $this->belongsToMany('App\Models\Image', 'article_images');

    }
}
