<?php


namespace App\Services\Lib;


use App\Contracts\OrderItemRepositoryInterface;
use App\Models\OrderItem;
use App\Services\Contracts\InstallmentArrayGeneratorInterface;

class InstallmentArrayGenerator implements InstallmentArrayGeneratorInterface
{
    /**
     * @var OrderItemRepositoryInterface
     */
    protected $orderItemRepository;

    /**
     * InstallmentArrayGenerator constructor.
     * @param OrderItemRepositoryInterface $orderItemRepository
     */
    public function __construct(OrderItemRepositoryInterface $orderItemRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
    }

    /**
     * Installments array consists of all of the installment prices array

     * @param $orderId
     * @return array
     */
    public function generate($orderId)
    {
        $installmentsArray = [];
        foreach ($this->orderItemRepository->orderItems($orderId) as $orderItem) {
            /** @var OrderItem $orderItem */

            for ($i = 1; $i <= $orderItem->month_count; $i++) {
                /** @var OrderItem $orderItem */
                $installmentsArray[$i][] = $orderItem->monthlyPrice();
            }
        }

        return $installmentsArray;
    }
}
