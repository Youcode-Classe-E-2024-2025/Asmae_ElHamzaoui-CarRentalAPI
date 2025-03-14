<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * @package App\Models
 *
 * @property int $id
 * @property int $rental_id
 * @property float $amount
 * @property string $payment_method
 * @property string $payment_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['rental_id', 'amount', 'payment_method', 'payment_date'];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}

