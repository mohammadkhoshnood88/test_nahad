<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Blog extends Model
{
    public function comments()
    {
        return $this->hasMany('App\Models\BlogComment');
    }

    public function blogimges()
    {
        return $this->hasMany('App\Models\Blogimge');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function index($index)
    {
        $index = Blogimge::where('blog_id' , $this->id)
            ->where('index_id' , $index)->first();
        return $index->address;
    }

    public function images($index)
    {
        return $index = Blogimge::where('blog_id' , $this->id)
            ->where('index_id' , $index)->first();
    }

    public function publisher()
    {
        $publisher = Publisher::all()->where('id', $this->publisher_id)->first();

        return $publisher->name;
    }

    public function can_publish()
    {
        $publisher = Publisher::all()->where('id', $this->publisher_id)->first();

        return $publisher->user_id === Auth::user()->id;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($blog) {
            $blog->photos()->delete();

        });
    }

}
