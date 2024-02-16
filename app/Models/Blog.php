<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
     //protected $guarded=[];
     protected $fillable=['title','body','blog_image','published_at'];
    public function scopepublished($query)
    {
        return $query->whereNotNull('published_at');
    }
}
