<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'slug', 'title', 'content', 'img_url', 'status','publish_at'];

    public function categories():BelongsToMany
    {
        return $this->belongsToMany(Category::class,'category_articles');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
