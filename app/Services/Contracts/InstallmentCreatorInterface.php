<?php


namespace App\Services\Contracts;


interface InstallmentCreatorInterface
{
    public function create($order_id, $turn);

}
