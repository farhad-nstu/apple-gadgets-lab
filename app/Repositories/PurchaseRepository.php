<?php

namespace App\Repositories;

use App\Models\Purchase;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;

class PurchaseRepository
{
    protected Model $model;

    public function __construct(Purchase $model)
    {
        $this->model = $model;
    }

    public function getPurchaseOrders($request){
        try {
            return $this->model->with(['purchase_items.product', 'supplier'])->get();
        } catch (\Throwable $th) {
            throw new Exception("Database connectivity problem or query problem", 500);
        }
    }

    public function storePurchase(array $data) : Model
    {
        try {
            $totalAmount = 0;
            foreach ($data['quantity'] as $index => $quantity) {
                $totalAmount += $quantity * $data['unit_price'][$index];
            }

            $purchaseData = [
                'supplier_id' => $data['supplier_id'],
                'total_amount' => $totalAmount,
                'purchase_date' => Carbon::now()
            ];

            return $this->model->create($purchaseData);

        } catch (\PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage(), 500);
        } catch (\Exception $e) {
            throw new Exception("An unexpected error occurred: " . $e->getMessage(), 500);
        }
    }
}
