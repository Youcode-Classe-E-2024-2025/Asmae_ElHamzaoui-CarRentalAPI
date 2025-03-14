<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Rental
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property int $car_id
 * @property string $start_date
 * @property string $end_date
 * @property float $total_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */

class Rental extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'car_id', 'start_date', 'end_date', 'total_price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}

