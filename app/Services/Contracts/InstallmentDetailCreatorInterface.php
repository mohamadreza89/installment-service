<?php


namespace App\Services\Contracts;


interface InstallmentDetailCreatorInterface
{
    /**
     * @param $installment_id
     * @param $price
     * @param string $type
     * @return mixed
     */
    public function create($installment_id, $price, $type = "normal");

}
