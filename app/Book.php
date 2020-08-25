<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    protected $fillable = [
    	'isbn', 'title', 'author', 'copies', 'available', 'note'
    ];

    public function coverImage()
    {
    	return $this->hasOne('App\CoverImage');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'owes');
    }
}
