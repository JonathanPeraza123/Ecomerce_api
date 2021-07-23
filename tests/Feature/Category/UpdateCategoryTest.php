<?php

namespace Tests\Feature\Category;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_update_category()
    {
        $caterogory = Category::factory()->create();

        $url = route('categories.update', $caterogory->getRouteKey());
        $response = $this->putJson($url, [
            'name' => 'hogar',
            'slug' => 'hogar'
        ])->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'name' => 'hogar',
            'slug' => 'hogar'
        ]);
    }

    /** @test */
    public function can_update_the_name_only()
    {
        $caterogory = Category::factory()->create();

        $url = route('categories.update', $caterogory->getRouteKey());
        $response = $this->putJson($url, [
            'name' => 'hogar',
        ])->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'name' => 'hogar',
        ]);
    }

    /** @test */
    public function can_update_the_slug_only()
    {
        $caterogory = Category::factory()->create();

        $url = route('categories.update', $caterogory->getRouteKey());
        $response = $this->putJson($url, [
            'slug' => 'hogar',
        ])->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'slug' => 'hogar',
        ]);
    }
}
