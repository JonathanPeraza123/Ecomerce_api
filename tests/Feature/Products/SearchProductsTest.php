<?php

namespace Tests\Feature\Products;

use App\Models\Variation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_search_articles_by_name()
    {
        Variation::factory()->create([
            'name' => 'iphone 12 pro'
        ]);
        Variation::factory()->create([
            'name' => 'iphone 12 pro max'
        ]);
        Variation::factory()->create([
            'name' => 'Other name'
        ]);

        $url = route('p.index', ['search' => 'iphone']);

        $response = $this->getJson($url);
        $response->assertJsonCount(2, 'data')
            ->assertSee([
                'name' => 'iphone 12 pro',
                'name' => 'iphone 12 pro max'
            ])
            ->assertDontSee([
                'name' => 'Other name'
            ]);
    }

    /** @test */
    public function can_search_articles_by_name_whit_multiple_terms()
    {
        Variation::factory()->create([
            'name' => 'iphone 12 pro'
        ]);
        Variation::factory()->create([
            'name' => 'iphone 12 pro max'
        ]);

        Variation::factory()->create([
            'name' => 'iphone'
        ]);
        Variation::factory()->create([
            'name' => 'Other name'
        ]);

        $url = route('p.index', ['search' => 'iphone 12 pro']);

        $response = $this->getJson($url);
        $response->assertJsonCount(2, 'data')
            ->assertSee([
                'name' => 'iphone 12 pro',
                'name' => 'iphone 12 pro max',
                'name' => 'iphone'
            ])
            ->assertDontSee([
                'name' => 'Other name'
            ]);
    }
}
