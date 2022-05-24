<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;


class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
      return [
        'uid' => 1,
        'supplierid' => 1,
        'sku' => '',
        'title' => $this->faker->title,
        'slug' => preg_replace ("/[_\s]/", "", strtolower($this->faker->title)),
        'description' => $this->faker->text,
        'cp' => $this->faker->cp,
        'wp' => $this->faker->wp,
        'op' => $this->faker->op,
        'sp' => $this->faker->sp,
        'quantity' => $this->faker->quantity,
        'sold' => $this->faker->sold,
      ];
    }
}
