<?php

namespace App\Repositories;

use App\Models\PurchaseItem;
use Exception;
use Illuminate\Database\Eloquent\Model;

class PurchaseItemRepository
{
    protected Model $model;

    public function __construct(PurchaseItem $model)
    {
        $this->model = $model;
    }

    public function storePurchaseItems(array $data, $purchase_id) : Model
    {
        try {
            // store multiple data into purhase item table
            foreach ($data['product_id'] as $index => $product_id) {
                $purchaseItemData = [
                    'purchase_id' => $purchase_id,
                    'product_id' => $product_id,
                    'quantity' => $data['quantity'][$index],
                    'unit_price' => $data['unit_price'][$index],
                    'total_price' => $data['quantity'][$index] * $data['unit_price'][$index]
                ];

                $this->model->create($purchaseItemData);
            }

            return $this->model->where('purchase_id', $purchase_id)->first();

        } catch (\PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage(), 500);
        } catch (\Exception $e) {
            throw new Exception("An unexpected error occurred: " . $e->getMessage(), 500);
        }
    }
}
