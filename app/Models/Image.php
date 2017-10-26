<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['article_id', 'image_id'];


    public function articles() {

        return $this->belongsToMany('App\Models\Article');

    }

    static public function store($image) {

        $fileName = 'm_' . rand(1, 999999) . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('/storage/images/'), $fileName);

        return $fileName;

    }


}
