<?php


namespace App\Contracts;


interface OrderItemRepositoryInterface
{
    public function orderItems($orderId);

}
