<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Variation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(4),
            'slug' => $this->faker->slug,
            'price' => 400.00,
            'quantity' => 10,
            'description' => $this->faker->paragraphs(3, true),
            'in_stock' => 1,
            'product_id' => Product::factory(),

        ];
    }
}
