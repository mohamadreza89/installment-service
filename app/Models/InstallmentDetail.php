<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer price
 */
class InstallmentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "installment_id",
        "price",
        "installment_type"
    ];
}
