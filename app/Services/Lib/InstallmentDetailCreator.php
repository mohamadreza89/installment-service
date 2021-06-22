<?php


namespace App\Services\Lib;


use App\Services\Contracts\InstallmentDetailCreatorInterface;
use Illuminate\Database\Eloquent\Builder;

class InstallmentDetailCreator extends Creator implements InstallmentDetailCreatorInterface
{
    public function create($installment_id, $price, $type = "normal")
    {
        return $this->builder->create([
            "installment_id" => $installment_id,
            "price" => $price,
            "installment_type"=> $type
        ]);
    }
}
