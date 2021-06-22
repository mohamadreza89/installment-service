<?php


namespace App\Services\Lib;


use App\Services\Contracts\InstallmentCreatorInterface;

class InstallmentCreator extends Creator implements InstallmentCreatorInterface
{

    /**
     * @param $order_id
     * @param $turn
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create($order_id, $turn)
    {
        return $this->builder->create([
            "order_id" => $order_id,
            "turn" => $turn
        ]);
    }
}
