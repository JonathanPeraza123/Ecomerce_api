<?php

namespace Tests\Feature\Brands;

use App\Models\Brand;
use App\Models\Variation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListBrandsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_a_single_brand_whit_products()
    {
        $product = Variation::factory()->create();
        $product2 = Variation::factory()->create();

        $url = route('brands.show', $product->product->brand->getRouteKey());

        $reponse = $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee([
                'name' => $product->name
            ])->assertDontSee([
                'name' => $product2->name
            ]);
    }

    /** @test */
    public function can_fetch_all_brands_whit()
    {
        $brand1 = Brand::factory()->create();
        $brand2 = Brand::factory()->create();
        $brand3 = Brand::factory()->create();
        $brand4 = Brand::factory()->create();


        $url = route('brands.index');

        $reponse = $this->getJson($url)
            ->assertJsonCount(4, 'data');
        $reponse->assertJsonFragment([
            'data' => [
                [
                    'type' => 'brand',
                    'id' => (string) $brand1->getRouteKey(),
                    'attributes' => [
                        'name' => $brand1->name,
                        'slug' => $brand1->slug
                    ],
                    'links' => [
                        'self' => route('brands.show', $brand1->getRouteKey())
                    ]
                ],
                [
                    'type' => 'brand',
                    'id' => (string) $brand2->getRouteKey(),
                    'attributes' => [
                        'name' => $brand2->name,
                        'slug' => $brand2->slug
                    ],
                    'links' => [
                        'self' => route('brands.show', $brand2->getRouteKey())
                    ]
                ],
                [
                    'type' => 'brand',
                    'id' => (string) $brand3->getRouteKey(),
                    'attributes' => [
                        'name' => $brand3->name,
                        'slug' => $brand3->slug
                    ],
                    'links' => [
                        'self' => route('brands.show', $brand3->getRouteKey())
                    ]
                ],
                [
                    'type' => 'brand',
                    'id' => (string) $brand4->getRouteKey(),
                    'attributes' => [
                        'name' => $brand4->name,
                        'slug' => $brand4->slug
                    ],
                    'links' => [
                        'self' => route('brands.show', $brand4->getRouteKey())
                    ]
                ]
            ]
        ]);
    }
}
