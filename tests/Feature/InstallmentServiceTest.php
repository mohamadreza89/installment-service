<?php

namespace Tests\Feature;

use App\Contracts\InstallmentServiceInterface;
use App\Models\Installment;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class InstallmentServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Order
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


    public function test_second_installments_price_should_be_equal_to_total_returning_price_divided_by_months_count()
    {
        /** @var InstallmentServiceInterface $service */
        $service = app(InstallmentServiceInterface::class);
        $service->create($this->order->id);

        $installments= $this->order->installments;

        /** @var Installment $installment */
        $installment = $installments[2];

        $this->assertEquals(2000000*2*1.2/12 + 3000000*1.2/6 , $installment->total_price);

    }

    public function test_first_installments_price_should_be_equal_to_total_returning_price_divided_by_months_count_plus_extra_values()
    {
        Config::set("accounting.delivery", 5000);
        Config::set("accounting.VAT", 5000);

        /** @var InstallmentServiceInterface $service */
        $service = app(InstallmentServiceInterface::class);
        $service->create($this->order->id);

        $installments= $this->order->installments;
        //dd($installments->toArray());

        /** @var Installment $installment */
        $installment = $installments[0];


        $this->assertEquals(2000000*2*1.2/12 + 3000000*1.2/6 + 10000 , $installment->total_price);
    }

}
