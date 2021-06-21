<?php

namespace App\Listeners;

use App\Contracts\HasOrderId;
use App\Contracts\InstallmentServiceInterface;

class CreateOrderInstallments
{
    /**
     * @var InstallmentServiceInterface
     */
    protected $installmentService;

    /**
     * Create the event listener.
     *
     * @param InstallmentServiceInterface $installmentService
     */
    public function __construct(InstallmentServiceInterface $installmentService)
    {
        $this->installmentService = $installmentService;
    }

    /**
     * Handle the event.
     *
     * @param HasOrderId $event
     * @return void
     */
    public function handle(HasOrderId $event)
    {
        $this->installmentService->create($event->orderId());


    }

}
