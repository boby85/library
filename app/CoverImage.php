<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoverImage extends Model
{
    protected $fillable = ['book_id', 'image'];

    public function book()
	{
		return $this->belongsTo('App\Book');
	}
}
