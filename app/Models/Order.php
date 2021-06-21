<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed orderItems
 * @property mixed installments
 * @property mixed total_price
 * @property mixed id
 */
class Order extends Model
{
    use HasFactory;

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }

    public function getTotalPriceAttribute()
    {
        $price = 0;
        foreach ($this->orderItems as $orderItem){
            /** @var OrderItem $orderItem */
            $price += $orderItem->totalReturningPrice();
        }
        return $price;

    }
}
