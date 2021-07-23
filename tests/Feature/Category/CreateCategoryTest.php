<?php

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_category()
    {
        $url = route('categories.store');
        $response = $this->postJson($url, [
            'name' => 'hogar',
            'slug' => 'hogar'
        ])->assertCreated();

        $this->assertDatabaseHas('categories', [
            'name' => 'hogar',
            'slug' => 'hogar'
        ]);
    }

    /** @test */
    public function name_is_required()
    {
        $url = route('categories.store');
        $response = $this->postJson($url, [
            'name' => '',
            'slug' => 'hogar'
        ])->assertStatus(422);

        $this->assertDatabaseCount('categories', 0);
    }

    /** @test */
    public function slug_is_required()
    {
        $url = route('categories.store');
        $response = $this->postJson($url, [
            'name' => 'hogar',
            'slug' => ''
        ])->assertStatus(422);
        $this->assertDatabaseCount('categories', 0);
    }

    /** @test */
    public function slug_must_must_only_contain_letters_numbers_and_dashes()
    {
        $url = route('categories.store');
        $response = $this->postJson($url, [
            'name' => 'hogar',
            'slug' => '$#%+¡'
        ])->assertStatus(422);
        $this->assertDatabaseCount('categories', 0);
    }

    /** @test */
    public function slug_must_must_not_contain_underscores()
    {
        $url = route('categories.store');
        $response = $this->postJson($url, [
            'name' => 'hogar',
            'slug' => 'with_underscores'
        ])->assertStatus(422);
        $this->assertDatabaseCount('categories', 0);
    }

    /** @test */
    public function slug_must_must_not_start_with_dashes()
    {
        $url = route('categories.store');
        $response = $this->postJson($url, [
            'name' => 'hogar',
            'slug' => '-start-with-dash'
        ])->assertStatus(422);
        $this->assertDatabaseCount('categories', 0);
    }

    /** @test */
    public function slug_must_must_not_end_with_dashes()
    {
        $url = route('categories.store');
        $response = $this->postJson($url, [
            'name' => 'hogar',
            'slug' => 'ends-with-dash-'
        ])->assertStatus(422);
        $this->assertDatabaseCount('categories', 0);
    }
}
