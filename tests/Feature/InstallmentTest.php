<?php

namespace Tests\Feature;

use App\Events\OrderCreated;
use App\Models\Installment;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class InstallmentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @var Order
     */
    protected $order;

    public function setUp(): void
    {
        parent::setUp();

        $this->order = Order::factory(1)->create()->first();

        OrderItem::factory(2)->create([
            "order_id"=>$this->order->id,
        ]);
    }

    public function test_orders_have_order_items()
    {
        $this->assertCount(2, $this->order->orderItems);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_installments_count_must_match_the_maximum_month_counts_of_the_order_items()
    {
        event(new OrderCreated($this->order->id));

        $maxMonthCount = $this->order->orderItems->max("month_count");

        $this->assertCount($maxMonthCount, $this->order->installments);

    }

    public function test_sum_of_installment_prices_must_be_equal_to_the_total_returning_price_of_each_order_item_plus_fixed_parts()
    {
        Config::set("accounting.delivery", 5000);
        Config::set("accounting.VAT", 5000);

        event(new OrderCreated($this->order->id));
        $orderTotalReturningPrice = $this->order->total_price;

        $installments = $this->order->installments;
        $price = 0;
        foreach ($installments as $installment){
            /** @var Installment $installment */
            $price += $installment->total_price;
        }

        $this->assertEquals($orderTotalReturningPrice + 10000, $price);

    }

    public function test_sum_of_installment_details_must_be_equal_to_the_total_order_items_month_count_plus_two()
    {
        event(new OrderCreated($this->order->id));

        $month_counts = 0;
        foreach ($this->order->orderItems as $orderItem){
            $month_counts += $orderItem->month_count;
        }

        $installments = $this->order->installments;
        $count = 0;
        foreach ($installments as $installment){
            /** @var Installment $installment */
            $count += $installment->installmentDetails->count();
        }

        $this->assertEquals($count - 2 , $month_counts );
    }
}
