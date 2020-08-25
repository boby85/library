<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    protected $fillable = ['user_id', 'image'];

    public function user()
	{
		return $this->belongsTo('App\User');
	}
}
