<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        return [
            "order_id" => Order::all()->random(1)->first()->id,
            "store_id" => random_int(1,100),
            "quantity" => random_int(1,10),
            "price" => $this->faker->randomElement([1000,2000,5000]),
            "month_count" => $this->faker->randomElement([3,6,12,24]),
        ];
    }
}
