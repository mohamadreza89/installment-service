<?php


namespace App\Repositories;


use App\Contracts\OrderItemRepositoryInterface;
use App\Models\OrderItem;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    /**
     * @param $orderId
     * @return mixed
     */
    public function orderItems($orderId)
    {
        return OrderItem::where("order_id", $orderId)->get();

    }

}
