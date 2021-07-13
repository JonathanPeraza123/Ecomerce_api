<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use App\Models\Variation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SortProductsTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function it_can_sort_products_by_price_asc()
    {
        Variation::factory()->create(['price' => 200]);
        Variation::factory()->create(['price' => 300]);
        Variation::factory()->create(['price' => 100]);

        $url = route('p.index', ['sort' => 'price']);

        $reponse = $this->getJson($url);
        $reponse->assertSeeInOrder([
            'price' => 100,
            'price' => 200,
            'price' => 300,
        ]);
    }

    /** @test */
    public function it_can_sort_products_by_price_desc()
    {
        Variation::factory()->create(['price' => 100]);
        Variation::factory()->create(['price' => 200]);
        Variation::factory()->create(['price' => 300]);

        $url = route('p.index', ['sort' => '-price']);

        $reponse = $this->getJson($url);
        $reponse->assertSeeInOrder([
            'price' => 300,
            'price' => 200,
            'price' => 100,
        ]);
    }

    /** @test */
    public function it_can_sort_products_by_name_asc()
    {
        Variation::factory()->create(['name' => 'C name']);
        Variation::factory()->create(['name' => 'A name']);
        Variation::factory()->create(['name' => 'B name']);

        $url = route('p.index', ['sort' => 'name']);

        $reponse = $this->getJson($url);
        $reponse->assertSeeInOrder([
            'name' => 'A name',
            'name' => 'B name',
            'name' => 'C name',
        ]);
    }

    /** @test */
    public function it_can_sort_products_by_name_desc()
    {
        Variation::factory()->create(['name' => 'C name']);
        Variation::factory()->create(['name' => 'A name']);
        Variation::factory()->create(['name' => 'B name']);

        $url = route('p.index', ['sort' => '-name']);

        $reponse = $this->getJson($url);
        $reponse->assertSeeInOrder([
            'name' => 'C name',
            'name' => 'B name',
            'name' => 'A name',
        ]);
    }

    /** @test */
    public function it_can_sort_products_by_price_and_name()
    {
        Variation::factory()->create([
            'name' => 'C name',
            'price' => 200
        ]);
        Variation::factory()->create([
            'name' => 'A name',
            'price' => 300
        ]);
        Variation::factory()->create([
            'name' => 'B name',
            'price' => 100
        ]);

        $url = route('p.index', ['sort' => 'price,-name']);

        $reponse = $this->getJson($url);
        $reponse->assertSeeInOrder([
            'price' => 100,
            'price' => 200,
            'price' => 300,
        ]);


        $url = route('p.index', ['sort' => '-name,price']);

        $reponse = $this->getJson($url);
        $reponse->assertSeeInOrder([
            'name' => 'C name',
            'name' => 'B name',
            'name' => 'A name',
        ]);
    }

    /** @test */
    public function it_cannot_sort_products_by_unknown_fields()
    {
        Variation::factory()->count(3)->create();

        $url = route('p.index', ['sort' => 'unknown']);

        $reponse = $this->getJson($url);
        $reponse->assertStatus(400);
    }
}
