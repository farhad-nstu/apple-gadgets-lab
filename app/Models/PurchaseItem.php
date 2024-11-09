<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = ['purchase_id', 'product_id', 'quantity', 'unit_price', 'total_price'];

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Add the stock update logic in the 'created' event
        static::created(function ($purchaseItem) {
            $product = Product::find($purchaseItem->product_id);

            if ($product) {
                $product->current_stock_quantity += $purchaseItem->quantity;
                $product->save();
            }
        });
    }
}
