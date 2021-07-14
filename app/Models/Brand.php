<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeName(Builder $Query, $value)
    {
        $Query->where('name', 'LIKE', "%{$value}%");
    }
}
