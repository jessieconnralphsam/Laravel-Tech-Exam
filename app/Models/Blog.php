<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    // Specify the table associated with the model
    protected $table = 'blog_posts';

    protected $fillable = ['user_id', 'title', 'content'];
}
