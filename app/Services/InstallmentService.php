<?php


namespace App\Services;


use App\Contracts\InstallmentServiceInterface;
use App\Contracts\OrderItemRepositoryInterface;
use App\Models\OrderItem;
use App\Services\Contracts\InstallmentArrayGeneratorInterface;
use App\Services\Contracts\InstallmentCreatorInterface;
use App\Services\Contracts\InstallmentDetailCreatorInterface;

class InstallmentService implements InstallmentServiceInterface
{
    /**
     * @var InstallmentDetailCreatorInterface
     */
    protected $installmentDetailCreator;
    /**
     * @var InstallmentCreatorInterface
     */
    protected $installmentCreator;
    /**
     * @var InstallmentArrayGeneratorInterface
     */
    protected $installmentArrayGenerator;


    /**
     * InstallmentService constructor.
     * @param InstallmentDetailCreatorInterface $installmentDetailCreator
     * @param InstallmentCreatorInterface $installmentCreator
     * @param InstallmentArrayGeneratorInterface $installmentArrayGenerator
     */
    public function __construct(InstallmentDetailCreatorInterface $installmentDetailCreator,
                                InstallmentCreatorInterface $installmentCreator,
                                InstallmentArrayGeneratorInterface $installmentArrayGenerator)
    {
        $this->installmentDetailCreator = $installmentDetailCreator;
        $this->installmentCreator = $installmentCreator;
        $this->installmentArrayGenerator = $installmentArrayGenerator;
    }

    /**
     * Creates Installments and InstallmentDetails based on
     * the given order_id
     *
     * @param $orderId
     */
    public function create($orderId)
    {
        $i = 0;
        foreach ($this->installmentArrayGenerator->generate($orderId) as $installment) {
            $installmentObject = $this->installmentCreator->create($orderId, ++$i, now()->addMonths($i));

            // first installment consists of two fixed items : VAT and delivery
            if ($installmentObject->turn ==1){
                $this->installmentDetailCreator->create($installmentObject->id, config("accounting.VAT"), "vat");
                $this->installmentDetailCreator->create($installmentObject->id, config("accounting.delivery"), "delivery");

            }

            // Here $installment is an array of prices and each price
            // is for an orderItem.
            // By iterating through installment prices we create installmentDetail
            // for each price
            foreach ($installment as $price) {
                $this->installmentDetailCreator->create($installmentObject->id, $price);
            }
        }

    }



}
