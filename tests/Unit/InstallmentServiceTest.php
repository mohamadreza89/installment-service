<?php

namespace Tests\Unit;

use App\Contracts\InstallmentServiceInterface;
use App\Models\Installment;
use App\Services\Contracts\InstallmentArrayGeneratorInterface;
use App\Services\InstallmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class InstallmentServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_creation_method_of_installment_service_with_faked_array()
    {
        $this->instance(InstallmentArrayGeneratorInterface::class, new FakeArrayGenerator());

        /** @var InstallmentServiceInterface $service */
        $service = app(InstallmentServiceInterface::class);

        $service->create(110);

        $this->assertEquals(500, Installment::where("order_id", 110)->get()[1]->total_price);


    }
}

class FakeArrayGenerator implements InstallmentArrayGeneratorInterface
{

    public function generate($orderId)
    {
        return [
            [1000, 200],
            [200,300],
            [200,300],
        ];
    }
}
