<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SortCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_sort_category_by_name_asc()
    {
        Category::factory()->create([
            'name' => 'B name'
        ]);
        Category::factory()->create([
            'name' => 'C name'
        ]);
        Category::factory()->create([
            'name' => 'A name'
        ]);

        $url = route('categories.index');

        $response = $this->getJson($url)
            ->assertSeeInOrder([
                'name' => 'A name',
                'name' => 'B name',
                'name' => 'C name'
            ]);
    }
}
