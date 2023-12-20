<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
   protected $fillable = ['name', 'user_id'];
    public function article():BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }

}
