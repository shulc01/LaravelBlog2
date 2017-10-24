<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['name', 'description', 'parent_id'];

    public $timestamps = false;

    public function articles() 
    {

    	return $this->hasMany('App\Models\Article');	

    }
}
