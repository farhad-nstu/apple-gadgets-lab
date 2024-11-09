<?php

namespace App\Repositories;

use App\Models\Supplier;
use Exception;
use Illuminate\Database\Eloquent\Model;

class SupplierRepository
{
    protected Model $model;

    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }

    public function getSupplierList($request){
        try {
            $perPage = $request->perPage ?? 10;
            $query = $this->model->active();

            // filter based on request input field
            if (isset($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
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

    public function storeSupplier(array $data) : Model
    {
        try {
            $supplierData = [
                'name' => $data['name'],
                'contact_info' => $data['contact_info'] ?? null,
                'address' => $data['address'] ?? null
            ];

            return $this->model->create($supplierData);

        } catch (\PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage(), 500);
        } catch (\Exception $e) {
            throw new Exception("An unexpected error occurred: " . $e->getMessage(), 500);
        }
    }

    public function updateSupplier(array $data, $id): Model
    {
        try {
            // Find the product, throw a 404 exception if not found
            $supplier = $this->model->findOrFail($id);

            // Filter the data to include only fields that are present
            $supplierData = array_filter([
                'name' => $data['name'] ?? null,
                'contact_info' => $data['contact_info'] ?? null,
                'address' => $data['address'] ?? null
            ], function ($value) {
                return !is_null($value);
            });

            // Update only the fields that are present in $supplierData
            $supplier->update($supplierData);

            return $supplier;

        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage(), 500);
        } catch (\Exception $e) {
            throw new \Exception("An unexpected error occurred: " . $e->getMessage(), 500);
        }
    }

    public function deleteSupplier($id) : Model
    {
        try {
            // Soft delete by calling delete() method as we use softDelete traits in model
            $supplier = $this->model->findOrFail($id);
            $supplier->delete();

            // Return the deleted supplier instance
            return $supplier;
        } catch (\PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage(), 500);
        } catch (\Exception $e) {
            throw new Exception("An unexpected error occurred: " . $e->getMessage(), 500);
        }
    }
}
