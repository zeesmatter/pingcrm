<?php

namespace Database\Factories;

use App\Models\Customers;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = ['active', 'inActive', 'blocked'];

        return [
            'name' => $this->faker->name,
            'email' =>  $this->faker->email,
            'parent_id' =>  ($customer = Customers::inRandomOrder()->first()) ? $customer->id : null,
            'subscribed' => $this->faker->boolean,
            'status'    =>  $status[$this->faker->numberBetween(0, 2)]
        ];
    }
}
