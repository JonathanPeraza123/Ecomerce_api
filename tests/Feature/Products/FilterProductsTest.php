<?php

namespace Tests\Feature\Products;

use App\Models\Variation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilterProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_filter_products_by_price_range_barato()
    {
        Variation::factory()->create(['price' => 5]);
        Variation::factory()->create(['price' => 15]);
        Variation::factory()->create(['price' => 20]);

        $url = route('p.index', ['filter[price]' => 'barato']);

        $response = $this->getJson($url);

        $response->assertJsonCount(2, 'data')
            ->assertSee([
                'price' => 5,
                'price' => 15,
            ])
            ->assertDontSee([
                'price' => 20,
            ]);
    }

    /** @test */
    public function can_filter_products_by_price_range_bueno()
    {
        Variation::factory()->create(['price' => 16]);
        Variation::factory()->create(['price' => 21]);
        Variation::factory()->create(['price' => 26]);

        $url = route('p.index', ['filter[price]' => 'bueno']);

        $response = $this->getJson($url);

        $response->assertJsonCount(2, 'data')
            ->assertSee([
                'price' => 16,
                'price' => 21,
            ])
            ->assertDontSee([
                'price' => 26,
            ]);
    }

    /** @test */
    public function can_filter_products_by_price_range_caro()
    {
        Variation::factory()->create(['price' => 40]);
        Variation::factory()->create(['price' => 35]);
        Variation::factory()->create(['price' => 51]);

        $url = route('p.index', ['filter[price]' => 'caro']);

        $response = $this->getJson($url);

        $response->assertJsonCount(2, 'data')
            ->assertSee([
                'price' => 40,
                'price' => 35,
            ])
            ->assertDontSee([
                'price' => 51,
            ]);
    }

    /** @test */
    public function can_filter_products_by_price_range_carito()
    {
        Variation::factory()->create(['price' => 100]);
        Variation::factory()->create(['price' => 75]);
        Variation::factory()->create(['price' => 15]);

        $url = route('p.index', ['filter[price]' => 'carito']);

        $response = $this->getJson($url);

        $response->assertJsonCount(2, 'data')
            ->assertSee([
                'price' => 100,
                'price' => 75,
            ]);
    }

    /** @test */
    public function can_filter_products_by_price_range_ramdon()
    {
        Variation::factory()->create(['price' => 10]);
        Variation::factory()->create(['price' => 40]);
        Variation::factory()->create(['price' => 64]);
        Variation::factory()->create(['price' => 78]);
        Variation::factory()->create(['price' => 81]);

        $url = route('p.index', ['filter[price]' => '60,80']);

        $response = $this->getJson($url);

        $response->assertJsonCount(2, 'data')
            ->assertSee([
                'price' => 64,
                'price' => 78,
            ]);
    }

    /** @test */
    public function cannot_filter_products_by_price_range_bad_request()
    {
        Variation::factory()->count(2)->create();

        $url = route('p.index', ['filter[price]' => 'badRequest']);

        $response = $this->getJson($url);

        $response->assertStatus(400);
    }

    /** @test */
    public function cannot_filter_unknowns()
    {
        Variation::factory()->count(2)->create();

        $url = route('p.index', ['filter[unknowns]' => 'carito']);

        $response = $this->getJson($url);

        $response->assertStatus(400);
    }
}
