<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comment extends Model
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'parent_id',
        'comment',
        'commentable_id',
        'commentable_type',
        'user_id',
        'username',
        'useremail',
        'created_at'
    ];

    // protected $dates = ['published_at'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }
    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function setCreatedAtAttribute($value)

    {
        $this->attributes['created_at'] = Carbon::createFromFormat('d/m/Y H:m:s', $value)->format('Y-m-d H:m:s');
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->format('d/m/Y');
    // }

}
