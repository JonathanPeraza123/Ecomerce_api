<?php

namespace Tests\Feature\Brands;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateBrandsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_update_brands()
    {
        $brand = Brand::factory()->create();

        $url = route('brands.update', $brand->getRouteKey());

        $response = $this->putJson($url, [
            'name' => 'apple',
            'slug' => 'apple'
        ])->assertStatus(200);
        $this->assertDatabaseHas('brands', [
            'name' => 'apple',
            'slug' => 'apple'
        ]);
    }

    /** @test */
    public function can_update_the_name_only()
    {
        $brand = Brand::factory()->create();

        $url = route('brands.update', $brand->getRouteKey());

        $response = $this->putJson($url, [
            'name' => 'apple',
        ])->assertStatus(200);
        $this->assertDatabaseHas('brands', [
            'name' => 'apple',
        ]);
    }

    /** @test */
    public function can_update_the_slug_only()
    {
        $brand = Brand::factory()->create();

        $url = route('brands.update', $brand->getRouteKey());

        $response = $this->putJson($url, [
            'slug' => 'apple',
        ])->assertStatus(200);
        $this->assertDatabaseHas('brands', [
            'slug' => 'apple',
        ]);
    }
}
