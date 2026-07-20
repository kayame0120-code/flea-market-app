<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Purchase;
use App\Models\Category;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'brand',
        'description',
        'price',
        'condition',
        'img_url'
    ];
    const CONDITIONS = [
        1 => '良好',
        2 => '目立った傷や汚れなし',
        3 => 'やや傷や汚れあり',
        4 => '状態が悪い',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function purchases()
    {
        return $this->hasOne(Purchase::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_category');
    }
    public function getConditionLabelAttribute()
    {
        return self::CONDITIONS[$this->condition];
    }
    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
    public function isSold(): bool
    {
        return $this->purchases()->exists();
    }
}
