<?php


namespace App\Services;


use App\Contracts\InstallmentServiceInterface;
use App\Models\Installment;
use App\Models\InstallmentDetail;
use App\Models\OrderItem;

class InstallmentService implements InstallmentServiceInterface
{
    /**
     * Creates Installments and InstallmentDetails based on
     * the given order_id
     *
     * @param $orderId
     */
    public function create($orderId)
    {
        $i = 0;
        foreach ($this->installmentsArray($orderId) as $installment) {
            $installmentObject = $this->createInstallment($orderId, ++$i);

            if ($installmentObject->turn ==1){
                $this->createInstallmentDetail($installmentObject, config("accounting.VAT"), "vat");
                $this->createInstallmentDetail($installmentObject, config("accounting.delivery"), "delivery");

            }

            // Here $installment may be an array of prices and each price
            // is for an orderItem.
            // By iterating through installment prices we create installmentDetail
            // for each price
            foreach ($installment as $price) {
                $this->createInstallmentDetail($installmentObject, $price);
            }
        }

    }

    /**
     * @param $orderId
     * @return mixed
     */
    protected function orderItems($orderId)
    {
        return OrderItem::where("order_id", $orderId)->get();
    }

    /**
     * Installments array consists of all of the installment prices array
     *
     * @param $orderId
     * @return array
     */
    protected function installmentsArray($orderId)
    {
        $installmentsArray = [];
        foreach ($this->orderItems($orderId) as $orderItem) {
            /** @var OrderItem $orderItem */

            for ($i = 1; $i <= $orderItem->month_count; $i++) {
                /** @var OrderItem $orderItem */
                $installmentsArray[$i][] = $orderItem->monthlyPrice();
            }
        }

        return $installmentsArray;
    }

    /**
     * @param $orderId
     * @param $i
     * @return mixed
     */
    protected function createInstallment($orderId, $i)
    {
        return Installment::create([
            "order_id" => $orderId,
            "turn" => $i
        ]);
    }

    /**
     * @param $installmentObject
     * @param $price
     * @param string $type
     * @return InstallmentDetail
     */
    protected function createInstallmentDetail($installmentObject, $price, $type = "normal")
    {
        return InstallmentDetail::create([
            "installment_id" => $installmentObject->id,
            "price" => $price,
            "installment_type"=> $type
        ]);
    }

}
