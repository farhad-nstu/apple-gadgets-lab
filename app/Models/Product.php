<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'sku', 'price', 'initial_stock_quantity', 'current_stock_quantity', 'category_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    // save a sku code while creating any product
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->sku = $product->generateUniqueSku();
        });
    }

    // generate a unique sku code
    public function generateUniqueSku()
    {
        $sku = 'SKU-' . strtoupper(Str::random(5));

        // To Ensure the generated SKU is unique
        while (self::where('sku', $sku)->exists()) {
            $sku = 'SKU-' . strtoupper(Str::random(5));
        }

        return $sku;
    }

    // To get the non deleted product
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
}
