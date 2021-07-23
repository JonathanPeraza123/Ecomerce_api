<?php

namespace Tests\Feature\Brands;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteBrandsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_update_test()
    {
        $brand = Brand::factory()->create();

        $url = route('brands.destroy', $brand->getRouteKey());

        $response = $this->deleteJson($url)
            ->assertStatus(204);
        $this->assertDatabaseCount('brands', 0);
    }
}
