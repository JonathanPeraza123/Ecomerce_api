<?php

namespace App\Http\Controllers\api;

use App\Rules\Slug;
use App\Models\Type;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Variation::search(request('search'))->applySorts(request('sort'))->applyFilters()->paginate();
        return ProductCollection::make($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand' => ['required', 'exists:brands,name'],
            'type' => ['required', 'exists:types,name'],
            'name' => ['required'],
            'slug' => ['required', 'alpha_dash', new Slug],
            'description' => ['required'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'in_stock' => ['required'],
        ]);

        $brand = Brand::where('name', $request->brand)->first();
        $type = Type::where('name', $request->type)->first();

        $product = Product::create([
            'brand_id' => $brand->id,
            'type_id' => $type->id
        ]);

        $variation = Variation::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'in_stock' => $request->in_stock,
            'product_id' => $product->id
        ]);

        return ProductResource::make($variation);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Variation $p)
    {
        $product = Product::where('id', $p->product_id)->first();
        $variations = $product->variations;
        return ProductCollection::make($variations);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
