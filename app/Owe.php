<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owe extends Model
{
	use SoftDeletes;

    protected $fillable = ['user_id', 'book_id'];
}
