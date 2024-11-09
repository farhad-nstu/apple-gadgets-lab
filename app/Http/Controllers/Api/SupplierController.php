<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Services\SupplierService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SupplierController extends Controller
{
    use ResponseTrait;

    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function getSupplierList(Request $request){
        try{
            [$code, $message, $data] = $this->supplierService->getSupplierList($request);
            if($code === Response::HTTP_OK){
                return $this->success($data, $message, $code);
            }
            return $this->error($message, null, $code, $data);
        } catch(\Exception $e){
            return $this->error('Something went wrong!', $e->getTrace(), 500);
        }
    }

    public function storeSupplier(SupplierStoreRequest $request)
    {
        try{
            [$code, $message, $data]  = $this->supplierService->storeSupplier($request->all());
            if($code === Response::HTTP_OK){
                return $this->success($data, $message, $code);
            }
            return $this->error($message, null, $code, $data);
        }catch(\Exception $e){
            return $e->getMessage();
            return $this->error('Something went wrong!', $e->getTrace(), 500);
        }
    }

    public function getSupplierDetails($id)
    {
        try{
            [$code, $message, $data]  = $this->supplierService->getSupplierDetails($id);
            if($code === Response::HTTP_OK){
                return $this->success($data, $message, $code);
            }
            return $this->error($message, null, $code, $data);
        }catch(\Exception $e){
            return $e->getMessage();
            return $this->error('Something went wrong!', $e->getTrace(), 500);
        }
    }

    public function updateSupplier(SupplierUpdateRequest $request, $id)
    {
        try{
            [$code, $message, $data]  = $this->supplierService->updateSupplier($request->all(), $id);
            if($code === Response::HTTP_OK){
                return $this->success($data, $message, $code);
            }
            return $this->error($message, null, $code, $data);
        }catch(\Exception $e){
            return $e->getMessage();
            return $this->error('Something went wrong!', $e->getTrace(), 500);
        }
    }

    public function deleteSupplier($id)
    {
        try{
            [$code, $message, $data]  = $this->supplierService->deleteSupplier($id);
            if($code === Response::HTTP_OK){
                return $this->success($data, $message, $code);
            }
            return $this->error($message, null, $code, $data);
        }catch(\Exception $e){
            return $e->getMessage();
            return $this->error('Something went wrong!', $e->getTrace(), 500);
        }
    }
}
