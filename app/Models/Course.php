<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable= [
        "title",
        "description",
        "content",
        "mentor_id",
        "category_id",
        "thumbnail"
    ];

    public function mentor(){
        return $this->belongsTo(User::class, "user_id");
    }

    public function category(){
        return $this->belongsTo(Category::class, "category_id");
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
