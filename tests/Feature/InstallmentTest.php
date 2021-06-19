<?php

namespace Tests\Feature;

use App\Models\Installment;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InstallmentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function installments_count_must_match_the_maximum_period_in_order()
    {
        $order = Order::factory()->create();

        OrderItem::factory([
            "order_id"=>$order->id,
        ])->create(2);

        $maxMonthCount = $order->orderItems->max("month_count");

        $this->assertCount($maxMonthCount, $order->installments);


    }
}
