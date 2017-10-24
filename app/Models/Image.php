<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['article_id', 'image_id'];

    //public $table = 'article_tag';

    //public $timestamps = false;

    /*public function category() {

    	// return $this->belongsTo('App\Models\Category');

    	return $this->belongsTo('App\Models\Category');

    }
*//*
    public function tags()
    {

    	return $this->belongsToMany('App\Models\Tag');

    }*/

    /*public function articles_images() {

    	return $this->belongsToMany('App\Models\Article_Image');

    }*/

    public function articles() {

        return $this->belongsToMany('App\Models\Article');

    }

    // public function articles_images() {

    //     return $this->belongsToMany('App\Models\Article');

    // }
}
