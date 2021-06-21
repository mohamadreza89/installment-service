<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed month_count
 * @property mixed price
 */
class OrderItem extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return string|null
     */
    public function monthlyPrice()
    {
        return bcdiv($this->totalReturningPrice(), $this->month_count);
    }

    /**
     * @return integer
     */
    public function totalReturningPrice()
    {
        return bcmul($this->price, 1 + $this->interestRate());
    }

    /**
     * Total returning price of an order item considering the VAT and delivery parts
     *
     * @return integer
     */
    public function totalReturningPriceConsideringExtras()
    {
        return bcmul($this->price, 1 + $this->interestRate())
            + config("accounting.VAT")
            + config("accounting.delivery");
    }

    /**
     * @return float
     */
    protected function interestRate()
    {
        // This code should be something like this :
        // return $this->order->store->interest_rate;

        //But because we are not going to work store objects we hard code this part
        return 0.2;
    }

    /**
     * The price of the first month is slightly different from other months.
     * It consists of two elements : VAT and delivery
     *
     * @return \Illuminate\Config\Repository|mixed|string|null
     */
    public function firstMonthPrice()
    {
        return bcdiv($this->totalReturningPrice(), $this->month_count)
            + config("accounting.VAT")
            + config("accounting.delivery");

    }
}
