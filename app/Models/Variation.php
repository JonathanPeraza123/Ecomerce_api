<?php

namespace App\Models;

use App\Models\Traits\HasSort;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Variation extends Model
{
    use HasFactory, HasSort;

    public $allowedSorts = ['name', 'price'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function product()
    {
        return $this->belongsTo(product::class);
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }

    public function scopeAllProducts(Builder $Query, $categoryOrbrand)
    {
        $products = $categoryOrbrand->products;
        $variations = [];
        foreach ($products as $product) {
            $variantion = $product->variations;
            $variations[] = $variantion[0];
            // $Query = $variantion[0];
        }
        return $variations;
    }

    public function scopeSearch(Builder $Query, $value)
    {

        if (is_null($value)) {
            return;
        }
        $Query->where('name', 'LIKE', "%{$value}%");
    }
}
