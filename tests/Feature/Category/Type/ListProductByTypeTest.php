<?php

namespace Tests\Feature\Category\Type;

use App\Models\Product;
use App\Models\Type;
use App\Models\Variation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListProductByTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_all_products_by_category_and_type()
    {
        $type = Type::factory()->create();
        $product1 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $product2 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $variation1 = Variation::factory()->create([
            'product_id' => $product1->id
        ]);
        $variation2 = Variation::factory()->create([
            'product_id' => $product2->id
        ]);

        $type2 = Type::factory()->create();
        $product3 = Product::factory()->create([
            'type_id' => $type2->id
        ]);
        $variation3 = Variation::factory()->create([
            'product_id' => $product3->id
        ]);

        $url = route('api.v1.show.type', $parameters = [
            'category' => $type->category->slug,
            'type' => $type->getRouteKey()
        ]);

        $reponse = $this->getJson($url)
            ->assertJsonCount(2, 'data')
            ->assertSee([
                'name' => $variation1->name,
                'name' => $variation2->name,
            ])
            ->assertDontSee([
                'name' => $variation3->name
            ]);
    }
}
