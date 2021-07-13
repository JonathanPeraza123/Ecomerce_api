<?php

namespace Tests\Feature\Products;

use App\Models\Variation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaginateProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_paginated_articles()
    {
        $products = Variation::factory()->count(20)->create();

        $url = route('p.index');

        $reponse = $this->getJson($url);
        $reponse->assertJsonCount(15, 'data');
    }
}
