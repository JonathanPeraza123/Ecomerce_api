<?php

namespace Tests\Feature\Products;

use App\Models\Variation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_update_products()
    {
        $products = Variation::factory()->create([
            'name' => 'iphone 12 pro max azul',
            'slug' => 'iphone-12-pro-max-azul',
            'price' => 1200
        ]);

        $url = route('p.update', $products->getRouteKey());

        $resposne = $this->putJson($url, [
            'name' => 'iphone 12 pro max verde de 128G',
            'slug' => 'iphone-12-prox-max-verde-de-128G',
            'price' => 1400.50,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo'
        ]);

        $resposne->assertSee(1400.50)
            ->assertDontSee(1200)
            ->assertDontSee('iphone 12 pro max azul')
            ->assertStatus(200);

        $this->assertDatabaseHas('variations', [
            'name' => 'iphone 12 pro max verde de 128G',
            'slug' => 'iphone-12-prox-max-verde-de-128G',
            'description' => 'El mejor iphone del mundo',
            'price' => 1400.50
        ]);
    }

    /** @test */
    public function can_update_the_name_only()
    {
        $products = Variation::factory()->create([
            'name' => 'iphone 12 pro max azul',
        ]);

        $url = route('p.update', $products->getRouteKey());

        $resposne = $this->putJson($url, [
            'name' => 'iphone 12 pro max verde de 128G',
        ]);

        $resposne->assertDontSee('iphone 12 pro max azul')
            ->assertStatus(200);

        $this->assertDatabaseHas('variations', [
            'name' => 'iphone 12 pro max verde de 128G',
        ]);
    }

    /** @test */
    public function can_update_the_slug_only()
    {
        $products = Variation::factory()->create([
            'slug' => 'iphone-12-pro-max-azul',
        ]);

        $url = route('p.update', $products->getRouteKey());

        $resposne = $this->putJson($url, [
            'slug' => 'iphone-12-pro-max-verde-de-128G',
        ]);

        $resposne->assertDontSee('iphone-12-pro-max-azul')
            ->assertStatus(200);

        $this->assertDatabaseHas('variations', [
            'slug' => 'iphone-12-pro-max-verde-de-128G',
        ]);
    }
}
