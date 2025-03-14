<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Car
 * @package App\Models
 *
 * @property int $id
 * @property string $brand
 * @property string $model
 * @property int $year
 * @property float $price_per_day
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['brand', 'model', 'year', 'price_per_day'];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}

