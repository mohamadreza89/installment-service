<?php


namespace App\Contracts;


interface InstallmentServiceInterface
{
    /**
     * Creates Installments and InstallmentDetails based on
     * the given order_id
     *
     * @param $orderId
     */
    public function create($orderId);

}
