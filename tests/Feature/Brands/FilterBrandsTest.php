<?php

namespace Tests\Feature\Brands;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilterBrandsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_filter_brands_by_name()
    {
        Brand::factory()->create([
            'name' => 'apple'
        ]);
        Brand::factory()->create([
            'name' => 'other name'
        ]);

        $url = route('brands.index', ['filter[name]' => 'apple']);

        $response = $this->getJson($url)->assertJsonCount(1, 'data');
        $response->assertSee([
            'name' => 'apple'
        ])->assertDontSee([
            'name' => 'other name'
        ]);
    }

    /** @test */
    public function cannot_filter_unknowns()
    {
        Brand::factory()->count(2)->create();

        $url = route('brands.index', ['filter[unknowns]' => 'apple']);

        $response = $this->getJson($url);

        $response->assertStatus(400);
    }
}
