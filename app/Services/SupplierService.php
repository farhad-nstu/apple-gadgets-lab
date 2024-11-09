<?php

namespace App\Services;

use App\Repositories\SupplierRepository;
use App\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;

class SupplierService
{
    use ResponseTrait;

    protected $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getSupplierList($request){
        try{
            $supplierList = $this->supplierRepository->getSupplierList($request);
            if($supplierList) {
                return [
                    Response::HTTP_OK,
                    "Supplier found successfully",
                    $supplierList
                ];
            } else {
                return [
                    Response::HTTP_OK,
                    "Data store failed",
                    []
                ];
            }
        } catch(\Exception $e){
            return [
                $e->getCode(),
                // $e->getMessage(),
                "Something went wrong",
                []
            ];
        }
    }

    public function storeSupplier(array $request) : array
    {
        try{
            $supplierData = $this->supplierRepository->storeSupplier($request);
            if($supplierData) {
                return [
                    Response::HTTP_OK,
                    "Supplier saved successfully",
                    $supplierData
                ];
            } else {
                return [
                    Response::HTTP_OK,
                    "Data store failed",
                    []
                ];
            }
        } catch(\Exception $e){
            return [
                $e->getCode(),
                "Something went wrong",
                []
            ];
        }
    }

    public function updateSupplier(array $request, $id) : array
    {
        try{
            $supplierData = $this->supplierRepository->updateSupplier($request, $id);
            if($supplierData) {
                return [
                    Response::HTTP_OK,
                    "Supplier updated successfully",
                    $supplierData
                ];
            } else {
                return [
                    Response::HTTP_OK,
                    "Data store failed",
                    []
                ];
            }
        } catch(\Exception $e){
            return [
                $e->getCode(),
                "Something went wrong",
                []
            ];
        }
    }

    public function deleteSupplier($id)
    {
        try{
            $supplier = $this->supplierRepository->deleteSupplier($id);
            if($supplier) {
                return [
                    Response::HTTP_OK,
                    "Supplier deleted successfully",
                    $supplier
                ];
            } else {
                return [
                    Response::HTTP_OK,
                    "Data store failed",
                    []
                ];
            }
        } catch(\Exception $e){
            return [
                $e->getCode(),
                "Something went wrong",
                []
            ];
        }
    }
}
