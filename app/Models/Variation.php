<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Traits\HasSort;
use Illuminate\Support\Facades\DB;
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

        if (sizeof($products) == 0) {
            abort(400);
        }

        foreach ($products as $product) {
            $variantion = $product->variations;
            $Query->orWhere('id', $variantion[0]->id);
        }
    }

    // public function scopeBrand(Builder $Query, $value)
    // {
    //     $brand = DB::table('brands')->where('name', $value)->get();
    //     $brand;

    //     $products = DB::table('products')->where('brand_id', $brand[0]->id)->get();
    //     dd($products);

    //     $identifiers = [];

    //     foreach ($products as $product) {
    //         $identifiers[] = $product->id;
    //     }

    //     foreach ($identifiers as $identifier) {
    //         $Query->orWhere('product_id', $identifier);
    //     }

    //     // $Query->where('category', 'LIKE', "%{$value}%");
    // }

    public function scopePrice(Builder $Query, $value)
    {
        if ($value == 'barato') {
            $Query->where('price', '<=', 15);
        }
        if ($value == 'bueno') {
            $Query->where('price', '<=', 25);
            $Query->where('price', '>', 15);
        }

        if ($value == 'caro') {
            $Query->where('price', '<=', 50);
            $Query->where('price', '>', 25);
        }

        if ($value == 'carito') {
            $Query->where('price', '>', 50);
        }
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
