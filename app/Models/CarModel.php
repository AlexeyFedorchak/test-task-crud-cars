<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function brand()
    {
        return $this->hasOne(CarBrand::class, 'id', 'brand_id');
    }
}
