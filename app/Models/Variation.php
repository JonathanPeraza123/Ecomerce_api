<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Traits\HasSort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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
        // $variations = [];
        // dd($products);

        if (sizeof($products) == 0) {
            abort(404);
        }

        foreach ($products as $product) {
            $variantion = $product->variations;
            // $variations[] = $variantion[0];
            $Query->where('id', $variantion[0]->id);
        }
        // return $variations;
    }

    public function scopeSearch(Builder $Query, $values)
    {
        if (is_null($values)) {
            return;
        }
        foreach (Str::of($values)->explode(' ') as $value) {
            $Query->where('name', 'LIKE', "%{$value}%");
        }
    }
}
