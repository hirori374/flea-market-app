<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','brand','price','image','condition','description','seller_id'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_category', 'item_id', 'category_id');
    }
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    public function purchase()
    {
        return $this->hasOne(Purchase::class, 'item_id');
    }
    public function favoritesUsers()
    {
        return $this->belongsToMany(User::class, 'item_user_favorites','item_id','user_id')->withTimestamps();
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
