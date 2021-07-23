<?php

namespace Tests\Feature\Brands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateBrandsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_brands()
    {
        $url = route('brands.store');
        $response = $this->postJson($url, [
            'name' => 'apple',
            'slug' => 'apple'
        ])->assertCreated();
        $this->assertDatabaseHas('brands', [
            'name' => 'apple',
            'slug' => 'apple'
        ]);
    }

    /** @test */
    public function name_is_requrired()
    {
        $url = route('brands.store');
        $response = $this->postJson($url, [
            'name' => '',
            'slug' => 'apple'
        ])->assertStatus(422);
        $this->assertDatabaseCount('brands', 0);
    }

    /** @test */
    public function slug_is_requrired()
    {
        $url = route('brands.store');
        $response = $this->postJson($url, [
            'name' => 'apple',
            'slug' => ''
        ])->assertStatus(422);
        $this->assertDatabaseCount('brands', 0);
    }

    /** @test */
    public function slug_must_must_only_contain_letters_numbers_and_dashes()
    {
        $url = route('brands.store');
        $response = $this->postJson($url, [
            'name' => 'apple',
            'slug' => '$#%+¡'
        ])->assertStatus(422);
        $this->assertDatabaseCount('brands', 0);
    }

    /** @test */
    public function slug_must_must_not_contain_underscores()
    {
        $url = route('brands.store');
        $response = $this->postJson($url, [
            'name' => 'apple',
            'slug' => 'with_underscores'
        ])->assertStatus(422);
        $this->assertDatabaseCount('brands', 0);
    }

    /** @test */
    public function slug_must_must_not_start_with_dashes()
    {
        $url = route('brands.store');
        $response = $this->postJson($url, [
            'name' => 'apple',
            'slug' => '-start-with-dash'
        ])->assertStatus(422);
        $this->assertDatabaseCount('brands', 0);
    }

    /** @test */
    public function slug_must_must_not_end_with_dashes()
    {
        $url = route('brands.store');
        $response = $this->postJson($url, [
            'name' => 'apple',
            'slug' => 'ends-with-dash-'
        ])->assertStatus(422);
        $this->assertDatabaseCount('brands', 0);
    }
}
