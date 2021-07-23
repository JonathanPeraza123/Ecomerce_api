<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_delete_category()
    {
        $category = Category::factory()->create();

        $url = route('categories.destroy', $category->getRouteKey());

        $response = $this->deleteJson($url)->assertStatus(204);
        $this->assertDatabaseCount('categories', 0);
    }
}
