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
        $products1 = Variation::factory()->create(['price' => 5]);
        $products2 = Variation::factory()->create(['price' => 15]);
        $products3 = Variation::factory()->create(['price' => 20]);

        $url = route('p.index', ['filter[price]' => 'barato']);

        $response = $this->getJson($url);

        $response->assertJsonCount(2, 'data')
            ->assertSee($products1->name)
            ->assertSee($products2->name)
            ->assertDontSee($products3->name);
    }

    /** @test */
    public function can_filter_products_by_price_range_bueno()
    {
        $products1 = Variation::factory()->create(['price' => 16]);
        $products2 = Variation::factory()->create(['price' => 21]);
        $products3 = Variation::factory()->create(['price' => 26]);

        $url = route('p.index', ['filter[price]' => 'bueno']);

        $response = $this->getJson($url);

        $response->assertJsonCount(2, 'data')
            ->assertSee($products1->name)
            ->assertSee($products2->name)
            ->assertDontSee($products3->name);
    }

    /** @test */
    public function can_filter_products_by_price_range_caro()
    {
        $products1 = Variation::factory()->create(['price' => 40]);
        $products2 = Variation::factory()->create(['price' => 35]);
        $products3 = Variation::factory()->create(['price' => 51]);

        $url = route('p.index', ['filter[price]' => 'caro']);

        $response = $this->getJson($url);

        $response->assertJsonCount(2, 'data')
            ->assertSee($products1->name)
            ->assertSee($products2->name)
            ->assertDontSee($products3->name);
    }

    /** @test */
    public function can_filter_products_by_price_range_carito()
    {
        $products1 = Variation::factory()->create(['price' => 100]);
        $products2 = Variation::factory()->create(['price' => 75]);
        $products3 = Variation::factory()->create(['price' => 9]);

        $url = route('p.index', ['filter[price]' => 'carito']);

        $response = $this->getJson($url);

        $response->assertJsonCount(2, 'data')
            ->assertSee($products1->name)
            ->assertSee($products2->name)
            ->assertDontSee($products3->name);
    }

    /** @test */
    public function can_filter_products_by_price_range_ramdon()
    {
        $products1 = Variation::factory()->create(['price' => 9]);
        $products2 = Variation::factory()->create(['price' => 40]);
        $products3 = Variation::factory()->create(['price' => 64]);
        $products4 = Variation::factory()->create(['price' => 78]);
        $products5 = Variation::factory()->create(['price' => 81]);

        $url = route('p.index', ['filter[price]' => '60,80']);

        $response = $this->getJson($url);

        $response->assertJsonCount(2, 'data')
            ->assertSee($products3->name)
            ->assertSee($products4->name)
            ->assertDontSee($products5->name)
            ->assertDontSee($products1->name)
            ->assertDontSee($products2->name);
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
