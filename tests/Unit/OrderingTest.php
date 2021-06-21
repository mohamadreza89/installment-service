<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderItem;
use Tests\TestCase;

class OrderingTest extends TestCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public $order;
    /**
     * @var OrderItem
     */
    public $orderItem1;
    /**
     * @var OrderItem
     */
    public $orderItem2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->order = Order::factory()->create();
        /** @var OrderItem $orderItem1 */
        $this->orderItem1 = OrderItem::factory()->create([
            "order_id"=> $this->order->id,
            "quantity"=>2,
            "price"=> 2000000,
            "month_count"=>12
        ]);


        /** @var OrderItem $orderItem2 */
        $this->orderItem2 = OrderItem::factory()->create([
            "order_id"=> $this->order->id,
            "quantity"=>1,
            "price"=> 3000000,
            "month_count"=>6
        ]);
    }

    /**
     *
     * @return void
     */
    public function test_the_total_returning_price_method_of_order_item_model()
    {
        $this->assertEquals(1.2*2000000*2 , $this->orderItem1->totalReturningPrice());
        $this->assertEquals(1.2*3000000 , $this->orderItem2->totalReturningPrice());
    }


}
