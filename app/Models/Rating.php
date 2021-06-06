<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'published',
        'title',
        'description',
        'name',
        'subtitle',
        'text',
        'slug'
    ];

    public function bracelets() {
        return $this->belongsToMany(Bracelet::class)->withPivot('position', 'text_rating')->orderBy('pivot_position');
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    public function getLink() {

        $link = $this->slug;

        return route('pub.ratings.show', ['slug' => $link]); 
        
     }
}
