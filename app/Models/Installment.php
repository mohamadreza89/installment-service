<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed total_price
 * @property mixed installmentDetails
 */
class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        "order_id",
        "turn",
    ];

    public function installmentDetails()
    {
        return $this->hasMany(InstallmentDetail::class);
    }

    public function getTotalPriceAttribute()
    {
        $price = 0;
        foreach ($this->installmentDetails as $installmentDetail){
            /** @var InstallmentDetail $installmentDetail */
            $price += $installmentDetail->price;
        }
        return $price;
    }
}
