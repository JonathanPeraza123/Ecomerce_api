<?php

namespace Tests\Feature\Products;

use App\Models\Variation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateVariationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_variations_of_products()
    {
        // $this->withoutExceptionHandling();

        $product = Variation::factory()->create([
            'name' => 'iphone 12 pro max rojo',
            'slug' => 'iphone-12-pro-max-rojo'
        ]);

        $url = route('api.v1.storeVariation.product', $product->product_id);

        $reponse = $this->postJson($url, [
            'name' => 'iphone 12 pro max azul',
            'slug' => 'iphone-12-prox-max-azul',
            'price' => 400.50,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ]);

        $reponse->assertCreated();
        $url2 = route('p.show', $product->getRouteKey());

        $reponse2 = $this->getJson($url2)->assertJsonCount(2, 'data');
        $reponse2->assertSee('iphone 12 pro max rojo')
            ->assertSee('iphone 12 pro max azul');
    }

    /** @test */
    public function name_is_required()
    {
        // $this->withoutExceptionHandling();

        $product = Variation::factory()->create([
            'name' => 'iphone 12 pro max rojo',
            'slug' => 'iphone-12-pro-max-rojo'
        ]);

        $url = route('api.v1.storeVariation.product', $product->product_id);

        $reponse = $this->postJson($url, [
            'name' => '',
            'slug' => 'iphone-12-prox-max-azul',
            'price' => 400.50,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ]);

        $reponse->assertStatus(422);

        $url2 = route('p.show', $product->getRouteKey());

        $reponse2 = $this->getJson($url2)->assertJsonCount(1, 'data');
        $reponse2->assertSee('iphone 12 pro max rojo');
    }

    /** @test */
    public function slug_is_required()
    {
        // $this->withoutExceptionHandling();

        $product = Variation::factory()->create([
            'name' => 'iphone 12 pro max rojo',
            'slug' => 'iphone-12-pro-max-rojo'
        ]);

        $url = route('api.v1.storeVariation.product', $product->product_id);

        $reponse = $this->postJson($url, [
            'name' => 'iphone 12 prox max azul',
            'slug' => '',
            'price' => 400.50,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ]);

        $reponse->assertStatus(422);

        $url2 = route('p.show', $product->getRouteKey());

        $reponse2 = $this->getJson($url2)->assertJsonCount(1, 'data');
        $reponse2->assertSee('iphone 12 pro max rojo')
            ->assertDontSee('iphone 12 prox max azul');
    }


    /** @test */
    public function slug_must_must_only_contain_letters_numbers_and_dashes()
    {
        // $this->withoutExceptionHandling();

        $product = Variation::factory()->create([
            'name' => 'iphone 12 pro max rojo',
            'slug' => 'iphone-12-pro-max-rojo'
        ]);

        $url = route('api.v1.storeVariation.product', $product->product_id);

        $reponse = $this->postJson($url, [
            'name' => 'iphone 12 prox max azul',
            'slug' => '$#%+¡',
            'price' => 400.50,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ]);

        $reponse->assertStatus(422);

        $url2 = route('p.show', $product->getRouteKey());

        $reponse2 = $this->getJson($url2)->assertJsonCount(1, 'data');
        $reponse2->assertSee('iphone 12 pro max rojo')
            ->assertDontSee('iphone 12 prox max azul');
    }

    /** @test */
    public function slug_must_must_not_contain_underscores()
    {
        // $this->withoutExceptionHandling();

        $product = Variation::factory()->create([
            'name' => 'iphone 12 pro max rojo',
            'slug' => 'iphone-12-pro-max-rojo'
        ]);

        $url = route('api.v1.storeVariation.product', $product->product_id);

        $reponse = $this->postJson($url, [
            'name' => 'iphone 12 prox max azul',
            'slug' => 'with_underscores',
            'price' => 400.50,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ]);

        $reponse->assertStatus(422);

        $url2 = route('p.show', $product->getRouteKey());

        $reponse2 = $this->getJson($url2)->assertJsonCount(1, 'data');
        $reponse2->assertSee('iphone 12 pro max rojo')
            ->assertDontSee('iphone 12 prox max azul');
    }

    /** @test */
    public function slug_must_must_not_start_with_dashes()
    {
        // $this->withoutExceptionHandling();

        $product = Variation::factory()->create([
            'name' => 'iphone 12 pro max rojo',
            'slug' => 'iphone-12-pro-max-rojo'
        ]);

        $url = route('api.v1.storeVariation.product', $product->product_id);

        $reponse = $this->postJson($url, [
            'name' => 'iphone 12 prox max azul',
            'slug' => '-start-with-dash',
            'price' => 400.50,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ]);

        $reponse->assertStatus(422);

        $url2 = route('p.show', $product->getRouteKey());

        $reponse2 = $this->getJson($url2)->assertJsonCount(1, 'data');
        $reponse2->assertSee('iphone 12 pro max rojo')
            ->assertDontSee('iphone 12 prox max azul');
    }

    /** @test */
    public function slug_must_must_not_end_with_dashes()
    {
        // $this->withoutExceptionHandling();

        $product = Variation::factory()->create([
            'name' => 'iphone 12 pro max rojo',
            'slug' => 'iphone-12-pro-max-rojo'
        ]);

        $url = route('api.v1.storeVariation.product', $product->product_id);

        $reponse = $this->postJson($url, [
            'name' => 'iphone 12 prox max azul',
            'slug' => 'ends-with-dash-',
            'price' => 400.50,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ]);

        $reponse->assertStatus(422);

        $url2 = route('p.show', $product->getRouteKey());

        $reponse2 = $this->getJson($url2)->assertJsonCount(1, 'data');
        $reponse2->assertSee('iphone 12 pro max rojo')
            ->assertDontSee('iphone 12 prox max azul');
    }

    /** @test */
    public function price_is_required()
    {
        // $this->withoutExceptionHandling();

        $product = Variation::factory()->create([
            'name' => 'iphone 12 pro max rojo',
            'slug' => 'iphone-12-pro-max-rojo'
        ]);

        $url = route('api.v1.storeVariation.product', $product->product_id);

        $reponse = $this->postJson($url, [
            'name' => 'iphone 12 prox max azul',
            'slug' => 'iphone-12-prox-max-azul',
            'price' => '',
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ]);

        $reponse->assertStatus(422);

        $url2 = route('p.show', $product->getRouteKey());

        $reponse2 = $this->getJson($url2)->assertJsonCount(1, 'data');
        $reponse2->assertSee('iphone 12 pro max rojo')
            ->assertDontSee('iphone 12 prox max azul');
    }

    /** @test */
    public function price_is_numeric()
    {
        // $this->withoutExceptionHandling();

        $product = Variation::factory()->create([
            'name' => 'iphone 12 pro max rojo',
            'slug' => 'iphone-12-pro-max-rojo'
        ]);

        $url = route('api.v1.storeVariation.product', $product->product_id);

        $reponse = $this->postJson($url, [
            'name' => 'iphone 12 prox max azul',
            'slug' => 'iphone-12-prox-max-azul',
            'price' => 'No-numeric',
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ]);

        $reponse->assertStatus(422);

        $url2 = route('p.show', $product->getRouteKey());

        $reponse2 = $this->getJson($url2)->assertJsonCount(1, 'data');
        $reponse2->assertSee('iphone 12 pro max rojo')
            ->assertDontSee('iphone 12 prox max azul');
    }

    /** @test */
    public function quantity_is_required()
    {
        // $this->withoutExceptionHandling();

        $product = Variation::factory()->create([
            'name' => 'iphone 12 pro max rojo',
            'slug' => 'iphone-12-pro-max-rojo'
        ]);

        $url = route('api.v1.storeVariation.product', $product->product_id);

        $reponse = $this->postJson($url, [
            'name' => 'iphone 12 prox max azul',
            'slug' => 'iphone-12-prox-max-azul',
            'price' => 400.50,
            'quantity' => '',
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ]);

        $reponse->assertStatus(422);

        $url2 = route('p.show', $product->getRouteKey());

        $reponse2 = $this->getJson($url2)->assertJsonCount(1, 'data');
        $reponse2->assertSee('iphone 12 pro max rojo')
            ->assertDontSee('iphone 12 prox max azul');
    }

    /** @test */
    public function quantity_is_numeric()
    {
        // $this->withoutExceptionHandling();

        $product = Variation::factory()->create([
            'name' => 'iphone 12 pro max rojo',
            'slug' => 'iphone-12-pro-max-rojo'
        ]);

        $url = route('api.v1.storeVariation.product', $product->product_id);

        $reponse = $this->postJson($url, [
            'name' => 'iphone 12 prox max azul',
            'slug' => 'iphone-12-prox-max-azul',
            'price' => 400.50,
            'quantity' => 'No numeric',
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ]);

        $reponse->assertStatus(422);

        $url2 = route('p.show', $product->getRouteKey());

        $reponse2 = $this->getJson($url2)->assertJsonCount(1, 'data');
        $reponse2->assertSee('iphone 12 pro max rojo')
            ->assertDontSee('iphone 12 prox max azul');
    }

    /** @test */
    public function description_is_required()
    {
        // $this->withoutExceptionHandling();

        $product = Variation::factory()->create([
            'name' => 'iphone 12 pro max rojo',
            'slug' => 'iphone-12-pro-max-rojo'
        ]);

        $url = route('api.v1.storeVariation.product', $product->product_id);

        $reponse = $this->postJson($url, [
            'name' => 'iphone 12 prox max azul',
            'slug' => 'iphone-12-prox-max-azul',
            'price' => 400.50,
            'quantity' => 27,
            'description' => '',
            'in_stock' => true,
        ]);

        $reponse->assertStatus(422);

        $url2 = route('p.show', $product->getRouteKey());

        $reponse2 = $this->getJson($url2)->assertJsonCount(1, 'data');
        $reponse2->assertSee('iphone 12 pro max rojo')
            ->assertDontSee('iphone 12 prox max azul');
    }
}
