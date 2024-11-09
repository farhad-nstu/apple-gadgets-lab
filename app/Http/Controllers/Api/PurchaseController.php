<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseStoreRequest;
use App\Models\Purchase;
use App\Services\PurchaseService;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;

class PurchaseController extends Controller
{
    use ResponseTrait;

    protected $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    public function getPurchaseOrders(Request $request){
        try{
            [$code, $message, $data] = $this->purchaseService->getPurchaseOrders($request);
            if($code === Response::HTTP_OK){
                return $this->success($data, $message, $code);
            }
            return $this->error($message, null, $code, $data);
        } catch(\Exception $e){
            return $this->error('Something went wrong!', $e->getTrace(), 500);
        }
    }

    public function storePurchaseOrder(PurchaseStoreRequest $request)
    {
        try{
            // dd(Purchase::all());
            [$code, $message, $data]  = $this->purchaseService->storePurchaseOrder($request->all());
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
