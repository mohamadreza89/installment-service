<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed month_count
 * @property mixed price
 * @property mixed quantity
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
        return bcmul(bcmul($this->price, $this->quantity), 1 + $this->interestRate());
    }

    /**
     * @return float
     */
    protected function interestRate()
    {
        // This code should be something like this :
        // $this->store->interest_rate;

        // But temporarily I write it this way
        return Store::make()->interestRate();


    }

}
