<?php

namespace Tests\Feature\Products;

use App\Models\Variation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_delete_variants_with_products()
    {
        $product = Variation::factory()->create();

        $url = route('p.destroy', $product->getRouteKey());

        $reponse = $this->deleteJson($url)->assertStatus(204);
        $this->assertDatabaseCount('products', 0);
    }

    /** @test */
    public function can_delete_one_variants()
    {
        $product = Variation::factory()->create();

        $variation = Variation::factory()->create([
            'product_id' => $product->product_id
        ]);

        $url = route('p.destroy', $product->getRouteKey());

        $reponse = $this->deleteJson($url)->assertStatus(204);
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseCount('variations', 1);
    }
}
