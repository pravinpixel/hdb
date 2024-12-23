<?php

namespace App\Models;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    public $guarded = [];
    
    use HasFactory, SoftDeletes;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function approveRequestByUser()
    {
        return $this->hasMany(ApproveRequest::class,'item_id', 'id');
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'checkout_by');
    }

    public function checkouts()
    {
        return $this->hasMany(Checkout::class, 'item_id', 'id');
    }

}
