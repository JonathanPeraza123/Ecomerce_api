<?php

namespace Tests\Feature\Category\Type;

use Tests\TestCase;
use App\Models\Type;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterProductByTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_filter_products_by_price_range_barato()
    {
        $type = Type::factory()->create();
        $product1 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $product2 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $product3 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $variation1 = Variation::factory()->create([
            'product_id' => $product1->id,
            'price' => 5
        ]);
        $variation2 = Variation::factory()->create([
            'product_id' => $product2->id,
            'price' => 10
        ]);

        $variation3 = Variation::factory()->create([
            'product_id' => $product3->id,
            'price' => 16
        ]);

        $url = route('api.v1.show.type', $parameters = [
            'category' => $type->category->slug,
            'type' => $type->getRouteKey(),
            'filter[price]' => 'barato'
        ]);

        $response = $this->getJson($url)
            ->assertJsonCount(2, 'data')
            ->assertSee($variation1->name)
            ->assertSee($variation2->name)
            ->assertDontSee($variation3->name);
    }

    /** @test */
    public function can_filter_products_by_price_range_bueno()
    {
        $type = Type::factory()->create();
        $product1 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $product2 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $product3 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $variation1 = Variation::factory()->create([
            'product_id' => $product1->id,
            'price' => 17
        ]);
        $variation2 = Variation::factory()->create([
            'product_id' => $product2->id,
            'price' => 23
        ]);

        $variation3 = Variation::factory()->create([
            'product_id' => $product3->id,
            'price' => 26
        ]);

        $url = route('api.v1.show.type', $parameters = [
            'category' => $type->category->slug,
            'type' => $type->getRouteKey(),
            'filter[price]' => 'bueno'
        ]);

        $response = $this->getJson($url)
            ->assertJsonCount(2, 'data')
            ->assertSee($variation1->name)
            ->assertSee($variation2->name)
            ->assertDontSee($variation3->name);
    }

    /** @test */
    public function can_filter_products_by_price_range_caro()
    {
        $type = Type::factory()->create();
        $product1 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $product2 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $product3 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $variation1 = Variation::factory()->create([
            'product_id' => $product1->id,
            'price' => 35
        ]);
        $variation2 = Variation::factory()->create([
            'product_id' => $product2->id,
            'price' => 47
        ]);

        $variation3 = Variation::factory()->create([
            'product_id' => $product3->id,
            'price' => 51
        ]);

        $url = route('api.v1.show.type', $parameters = [
            'category' => $type->category->slug,
            'type' => $type->getRouteKey(),
            'filter[price]' => 'caro'
        ]);

        $response = $this->getJson($url)
            ->assertJsonCount(2, 'data')
            ->assertSee($variation1->name)
            ->assertSee($variation2->name)
            ->assertDontSee($variation3->name);
    }

    /** @test */
    public function can_filter_products_by_price_range_carito()
    {
        $type = Type::factory()->create();
        $product1 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $product2 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $product3 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $variation1 = Variation::factory()->create([
            'product_id' => $product1->id,
            'price' => 75
        ]);
        $variation2 = Variation::factory()->create([
            'product_id' => $product2->id,
            'price' => 100
        ]);

        $variation3 = Variation::factory()->create([
            'product_id' => $product3->id,
            'price' => 10
        ]);

        $url = route('api.v1.show.type', $parameters = [
            'category' => $type->category->slug,
            'type' => $type->getRouteKey(),
            'filter[price]' => 'carito'
        ]);

        $response = $this->getJson($url)
            ->assertJsonCount(2, 'data')
            ->assertSee($variation1->name)
            ->assertSee($variation2->name)
            ->assertDontSee($variation3->name);
    }

    /** @test */
    public function can_filter_products_by_price_range_random()
    {
        $type = Type::factory()->create();
        $product1 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $product2 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $product3 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $variation1 = Variation::factory()->create([
            'product_id' => $product1->id,
            'price' => 10
        ]);
        $variation2 = Variation::factory()->create([
            'product_id' => $product2->id,
            'price' => 17
        ]);

        $variation3 = Variation::factory()->create([
            'product_id' => $product3->id,
            'price' => 20
        ]);

        $variation4 = Variation::factory()->create([
            'product_id' => $product3->id,
            'price' => 15
        ]);

        $url = route('api.v1.show.type', $parameters = [
            'category' => $type->category->slug,
            'type' => $type->getRouteKey(),
            'filter[price]' => '13,20'
        ]);

        $response = $this->getJson($url);

        $response->assertJsonCount(2, 'data')
            ->assertSee([$variation2->name])
            ->assertSee([$variation3->name])
            ->assertDontSee([$variation1->name])
            ->assertDontSee([$variation4->name]);
    }

    /** @test */
    public function cannot_filter_products_by_price_range_bad_request()
    {
        $type = Type::factory()->create();
        $product1 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $product2 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $product3 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $variation1 = Variation::factory()->create([
            'product_id' => $product1->id,
            'price' => 10
        ]);
        $variation2 = Variation::factory()->create([
            'product_id' => $product2->id,
            'price' => 17
        ]);

        $variation3 = Variation::factory()->create([
            'product_id' => $product3->id,
            'price' => 20
        ]);

        $variation4 = Variation::factory()->create([
            'product_id' => $product3->id,
            'price' => 15
        ]);

        $url = route('api.v1.show.type', $parameters = [
            'category' => $type->category->slug,
            'type' => $type->getRouteKey(),
            'filter[price]' => 'badRequest'
        ]);

        $response = $this->getJson($url);

        $response->assertStatus(400);
    }

    /** @test */
    public function cannot_filter_unknowns()
    {
        $type = Type::factory()->create();
        $product1 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $product2 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $product3 = Product::factory()->create([
            'type_id' => $type->id
        ]);
        $variation1 = Variation::factory()->create([
            'product_id' => $product1->id,
            'price' => 10
        ]);
        $variation2 = Variation::factory()->create([
            'product_id' => $product2->id,
            'price' => 17
        ]);

        $variation3 = Variation::factory()->create([
            'product_id' => $product3->id,
            'price' => 20
        ]);

        $variation4 = Variation::factory()->create([
            'product_id' => $product3->id,
            'price' => 15
        ]);

        $url = route('api.v1.show.type', $parameters = [
            'category' => $type->category->slug,
            'type' => $type->getRouteKey(),
            'filter[unknowns]' => '10,20'
        ]);

        $response = $this->getJson($url);

        $response->assertStatus(400);
    }
}
