<?php

namespace App\Repositories;

use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Model;

class ProductRepository
{
    protected Model $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getProductList($request){
        try {
            $perPage = $request->perPage ?? 10;
            $query = $this->model->active();

            // filter based on request input field
            if (isset($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
            if (isset($request->category_id)) {
                $query->where('category_id', $request->category_id);
            }
            if(isset($request->sku)){
                $query->where('sku', $request->sku);
            }

            $data = $query->paginate($perPage);
            return [
                'data' => $data->items(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
            ];
        } catch (\Throwable $th) {
            throw new Exception("Database connectivity problem or query problem", 500);
        }
    }

    public function storeProduct(array $data) : Model
    {
        try {
            $productData = [
                'name' => $data['name'],
                'category_id' => $data['category_id'] ?? 1,
                'price' => $data['price'],
                'initial_stock_quantity' => $data['initial_stock_quantity'],
                'current_stock_quantity' => $data['initial_stock_quantity']
            ];

            return $this->model->create($productData);

        } catch (\PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage(), 500);
        } catch (\Exception $e) {
            throw new Exception("An unexpected error occurred: " . $e->getMessage(), 500);
        }
    }

    public function getProductDetails($id) : Model
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage(), 500);
        } catch (\Exception $e) {
            throw new Exception("An unexpected error occurred: " . $e->getMessage(), 500);
        }
    }

    public function updateProduct(array $data, $id): Model
    {
        try {
            // Find the product, throw a 404 exception if not found
            $product = $this->model->findOrFail($id);

            // Filter the data to include only fields that are present
            $productData = array_filter([
                'name' => $data['name'] ?? null,
                'category_id' => $data['category_id'] ?? null,
                'price' => $data['price'] ?? null,
                'current_stock_quantity' => $data['current_stock_quantity'] ?? null,
            ], function ($value) {
                return !is_null($value);
            });

            // Update only the fields that are present in $productData
            $product->update($productData);

            return $product;

        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage(), 500);
        } catch (\Exception $e) {
            throw new \Exception("An unexpected error occurred: " . $e->getMessage(), 500);
        }
    }

    public function deleteProduct($id) : Model
    {
        try {
            // Soft delete by calling delete() method as we use softDelete traits in model
            $product = $this->model->findOrFail($id);
            $product->delete();

            // Return the deleted product instance
            return $product;
        } catch (\PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage(), 500);
        } catch (\Exception $e) {
            throw new Exception("An unexpected error occurred: " . $e->getMessage(), 500);
        }
    }
}
