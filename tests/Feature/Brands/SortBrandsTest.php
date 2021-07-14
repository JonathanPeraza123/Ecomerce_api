<?php

namespace Tests\Feature\Brands;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SortBrandsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_sort_brands_by_name_asc()
    {
        Brand::factory()->create([
            'name' => 'B name'
        ]);
        Brand::factory()->create([
            'name' => 'C name'
        ]);
        Brand::factory()->create([
            'name' => 'A name'
        ]);


        $url = route('brands.index');

        $reponse = $this->getJson($url)
            ->assertSeeInOrder([
                'name' => 'A name',
                'name' => 'B name',
                'name' => 'C name',
            ]);
    }
}
