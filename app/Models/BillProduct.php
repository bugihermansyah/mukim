<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BillProduct extends Model
{
    use HasFactory;

    protected $table = 'bill_products';

    protected $fillable = [
        'building_id',
        'product_id',
        'name',
        'period',
        'price'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function building() : BelongsTo 
    {
        return $this->belongsTo(Building::class);   
    }
}
