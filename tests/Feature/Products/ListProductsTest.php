<?php

namespace Tests\Feature\Products;

use App\Models\Variation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_a_single_product()
    {
        $products = Variation::factory()->create();

        $url = route('p.show', $products->getRouteKey());
        $response = $this->getJson($url);
        $response->assertJsonFragment([
            'data' => [
                [
                    'type' => 'product',
                    'id' => (string) $products->getRouteKey(),
                    'brand' => $products->product->brand->name,
                    'attributes' => [
                        'name' => $products->name,
                        'slug' => $products->slug,
                        'price' => $products->price,
                        'quantify' => $products->quantity,
                        'description' => $products->description,
                        'in_stock' => $products->in_stock,
                    ],
                    'links' => [
                        'self' => route('p.show', $products->getRouteKey())
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function can_fetch_a_single_product_with_variations()
    {
        $products = Variation::factory()->create();

        $products2 = Variation::factory()->create(['product_id' => $products->product_id]);

        $url = route('p.show', $products->getRouteKey());
        $response = $this->getJson($url);
        $response->assertJsonFragment([
            'data' => [
                [
                    'type' => 'product',
                    'id' => (string) $products->getRouteKey(),
                    'brand' => $products->product->brand->name,
                    'attributes' => [
                        'name' => $products->name,
                        'slug' => $products->slug,
                        'price' => $products->price,
                        'quantify' => $products->quantity,
                        'description' => $products->description,
                        'in_stock' => $products->in_stock,
                    ],
                    'links' => [
                        'self' => route('p.show', $products->getRouteKey())
                    ]
                ],
                [
                    'type' => 'product',
                    'id' => (string) $products2->getRouteKey(),
                    'brand' => $products2->product->brand->name,
                    'attributes' => [
                        'name' => $products2->name,
                        'slug' => $products2->slug,
                        'price' => $products2->price,
                        'quantify' => $products2->quantity,
                        'description' => $products2->description,
                        'in_stock' => $products2->in_stock,
                    ],
                    'links' => [
                        'self' => route('p.show', $products2->getRouteKey())
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function can_fetch_all_product()
    {
        $product1 = Variation::factory()->create(['price' => 100]);
        $product2 = Variation::factory()->create(['price' => 200]);
        $product3 = Variation::factory()->create(['price' => 300]);

        $url = route('p.index');

        $response = $this->getJson($url);

        $response->assertJsonFragment([
            'data' => [
                [
                    'type' => 'product',
                    'id' => (string) $product1->getRouteKey(),
                    'brand' => $product1->product->brand->name,
                    'attributes' => [
                        'name' => $product1->name,
                        'slug' => $product1->slug,
                        'price' => $product1->price,
                        'quantify' => $product1->quantity,
                        'description' => $product1->description,
                        'in_stock' => $product1->in_stock,
                    ],
                    'links' => [
                        'self' => route('p.show', $product1->getRouteKey())
                    ]
                ],
                [
                    'type' => 'product',
                    'id' => (string) $product2->getRouteKey(),
                    'brand' => $product2->product->brand->name,
                    'attributes' => [
                        'name' => $product2->name,
                        'slug' => $product2->slug,
                        'price' => $product2->price,
                        'quantify' => $product2->quantity,
                        'description' => $product2->description,
                        'in_stock' => $product2->in_stock,
                    ],
                    'links' => [
                        'self' => route('p.show', $product2->getRouteKey())
                    ]
                ],
                [
                    'type' => 'product',
                    'id' => (string) $product3->getRouteKey(),
                    'brand' => $product3->product->brand->name,
                    'attributes' => [
                        'name' => $product3->name,
                        'slug' => $product3->slug,
                        'price' => $product3->price,
                        'quantify' => $product3->quantity,
                        'description' => $product3->description,
                        'in_stock' => $product3->in_stock,
                    ],
                    'links' => [
                        'self' => route('p.show', $product3->getRouteKey())
                    ]
                ]
            ]
        ]);
    }
}
