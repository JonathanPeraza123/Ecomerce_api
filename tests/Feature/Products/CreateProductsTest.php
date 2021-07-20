<?php

namespace Tests\Feature\Products;

use App\Models\Brand;
use App\Models\Type;
use App\Models\Variation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_products()
    {
        $this->withoutExceptionHandling();

        Type::factory()->create([
            'name' => 'celulares'
        ]);

        Brand::factory()->create([
            'name' => 'apple'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => 'apple',
            'type' => 'celulares',
            'name' => 'iphone 12 pro max',
            'slug' => 'iphone-12-prox-max',
            'price' => 400.50,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ]);

        $response->assertCreated();
    }

    /** @test */
    public function brand_is_required()
    {
        // $this->withoutExceptionHandling();

        Type::factory()->create([
            'name' => 'celulares'
        ]);

        Brand::factory()->create([
            'name' => 'apple'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => '',
            'type' => 'celulares',
            'name' => 'iphone 12 pro max',
            'slug' => 'iphone-12-prox-max',
            'price' => 400,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ])->assertStatus(422)
            ->assertSee('The given data was invalid.')
            ->assertSee('The brand field is required.');
    }

    /** @test */
    public function brand_has_to_have_a_value_that_exists()
    {
        // $this->withoutExceptionHandling();

        Type::factory()->create([
            'name' => 'celulares'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => 'apple',
            'type' => 'celulares',
            'name' => 'iphone 12 pro max',
            'slug' => 'iphone-12-prox-max',
            'price' => 400,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ])->assertStatus(422)
            ->assertSee('The selected brand is invalid.');
    }

    /** @test */
    public function type_is_required()
    {
        // $this->withoutExceptionHandling();

        Type::factory()->create([
            'name' => 'celulares'
        ]);

        Brand::factory()->create([
            'name' => 'apple'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => 'apple',
            'type' => '',
            'name' => 'iphone 12 pro max',
            'slug' => 'iphone-12-prox-max',
            'price' => 400,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ])->assertStatus(422)
            ->assertSee('The given data was invalid.')
            ->assertSee('The type field is required.');
    }

    /** @test */
    public function type_has_to_have_a_value_that_exists()
    {
        // $this->withoutExceptionHandling();

        Brand::factory()->create([
            'name' => 'apple'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => 'apple',
            'type' => 'celulares',
            'name' => 'iphone 12 pro max',
            'slug' => 'iphone-12-prox-max',
            'price' => 400,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ])->assertStatus(422)
            ->assertSee('The selected type is invalid.');
    }

    /** @test */
    public function name_is_required()
    {
        // $this->withoutExceptionHandling();

        Type::factory()->create([
            'name' => 'celulares'
        ]);

        Brand::factory()->create([
            'name' => 'apple'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => 'apple',
            'type' => 'celulares',
            'name' => '',
            'slug' => 'iphone-12-prox-max',
            'price' => 400,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ])->assertStatus(422)
            ->assertSee('The given data was invalid.')
            ->assertSee('The name field is required.');
    }

    /** @test */
    public function slug_is_required()
    {
        // $this->withoutExceptionHandling();

        Type::factory()->create([
            'name' => 'celulares'
        ]);

        Brand::factory()->create([
            'name' => 'apple'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => 'apple',
            'type' => 'celulares',
            'name' => 'iphone-12-prox-max',
            'slug' => '',
            'price' => 400,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ])->assertStatus(422)
            ->assertSee('The given data was invalid.')
            ->assertSee('The slug field is required.');
    }

    /** @test */
    public function slug_must_must_only_contain_letters_numbers_and_dashes()
    {
        // $this->withoutExceptionHandling();

        Type::factory()->create([
            'name' => 'celulares'
        ]);

        Brand::factory()->create([
            'name' => 'apple'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => 'apple',
            'type' => 'celulares',
            'name' => 'iphone-12-prox-max',
            'slug' => '$#%+¡',
            'price' => 400,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ])->assertStatus(422);
    }

    /** @test */
    public function slug_must_must_not_contain_underscores()
    {
        // $this->withoutExceptionHandling();

        Type::factory()->create([
            'name' => 'celulares'
        ]);

        Brand::factory()->create([
            'name' => 'apple'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => 'apple',
            'type' => 'celulares',
            'name' => 'iphone-12-prox-max',
            'slug' => 'with_underscores',
            'price' => 400,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ])->assertStatus(422);
    }

    /** @test */
    public function slug_must_must_not_start_with_dashes()
    {
        // $this->withoutExceptionHandling();

        Type::factory()->create([
            'name' => 'celulares'
        ]);

        Brand::factory()->create([
            'name' => 'apple'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => 'apple',
            'type' => 'celulares',
            'name' => 'iphone-12-prox-max',
            'slug' => '-start-with-dash',
            'price' => 400,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ])->assertStatus(422);
    }

    /** @test */
    public function slug_must_must_not_end_with_dashes()
    {
        // $this->withoutExceptionHandling();

        Type::factory()->create([
            'name' => 'celulares'
        ]);

        Brand::factory()->create([
            'name' => 'apple'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => 'apple',
            'type' => 'celulares',
            'name' => 'iphone-12-prox-max',
            'slug' => 'ends-with-dash-',
            'price' => 400,
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ])->assertStatus(422);
    }

    /** @test */
    public function price_is_required()
    {
        // $this->withoutExceptionHandling();

        Type::factory()->create([
            'name' => 'celulares'
        ]);

        Brand::factory()->create([
            'name' => 'apple'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => 'apple',
            'type' => 'celulares',
            'name' => 'iphone-12-prox-max',
            'slug' => 'ends-with-dash',
            'price' => '',
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ])->assertStatus(422);
    }

    /** @test */
    public function price_is_numeric()
    {
        // $this->withoutExceptionHandling();

        Type::factory()->create([
            'name' => 'celulares'
        ]);

        Brand::factory()->create([
            'name' => 'apple'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => 'apple',
            'type' => 'celulares',
            'name' => 'iphone-12-prox-max',
            'slug' => 'ends-with-dash',
            'price' => 'no numeric',
            'quantity' => 10,
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ])->assertStatus(422);
    }

    /** @test */
    public function quantity_is_required()
    {
        // $this->withoutExceptionHandling();

        Type::factory()->create([
            'name' => 'celulares'
        ]);

        Brand::factory()->create([
            'name' => 'apple'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => 'apple',
            'type' => 'celulares',
            'name' => 'iphone-12-prox-max',
            'slug' => 'ends-with-dash',
            'price' => 400.50,
            'quantity' => '',
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ])->assertStatus(422);
    }

    /** @test */
    public function quantity_is_numeric()
    {
        // $this->withoutExceptionHandling();

        Type::factory()->create([
            'name' => 'celulares'
        ]);

        Brand::factory()->create([
            'name' => 'apple'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => 'apple',
            'type' => 'celulares',
            'name' => 'iphone-12-prox-max',
            'slug' => 'ends-with-dash',
            'price' => 400.50,
            'quantity' => 'no mumeric',
            'description' => 'El mejor iphone del mundo',
            'in_stock' => true,
        ])->assertStatus(422);
    }

    /** @test */
    public function decription_is_required()
    {
        // $this->withoutExceptionHandling();

        Type::factory()->create([
            'name' => 'celulares'
        ]);

        Brand::factory()->create([
            'name' => 'apple'
        ]);

        $url = route('p.store');

        $response = $this->postJson($url, [
            'brand' => 'apple',
            'type' => 'celulares',
            'name' => 'iphone-12-prox-max',
            'slug' => 'ends-with-dash',
            'price' => 400.50,
            'quantity' => 10,
            'description' => '',
            'in_stock' => true,
        ])->assertStatus(422);
    }
}
