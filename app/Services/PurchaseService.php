<?php

namespace App\Services;

use App\Repositories\PurchaseItemRepository;
use App\Repositories\PurchaseRepository;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PurchaseService
{
    use ResponseTrait;
    protected $purchaseRepository, $purchaseItemRepository;

    public function __construct(PurchaseRepository $purchaseRepository, PurchaseItemRepository $purchaseItemRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
        $this->purchaseItemRepository = $purchaseItemRepository;
    }

    public function getPurchaseOrders($request){
        try{
            $purchaseOrders = $this->purchaseRepository->getPurchaseOrders($request);
            if($purchaseOrders) {
                return [
                    Response::HTTP_OK,
                    "Purchase data get successfully",
                    $purchaseOrders
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

    /**
     * @param array $request
     *
     * @return array
     */
    public function storePurchaseOrder(array $request) : array
    {
        // apply db transaction in case any failure occurs during data store to multiple table
        DB::beginTransaction();

        try{
            $purchase = $this->purchaseRepository->storePurchase($request);
            $purchaseItems = $this->purchaseItemRepository->storePurchaseItems($request, $purchase->id);

            // Commit the transaction
            DB::commit();

            if($purchase && $purchaseItems) {
                $data = [
                    'purchase' => $purchase,
                    'purchase_items' => $purchaseItems,
                ];
                return [
                    Response::HTTP_OK,
                    "Data saved successfully",
                    $data
                ];
            } else {
                // Rollback transaction on PDOException
                DB::rollBack();
                return [
                    Response::HTTP_OK,
                    "Data store failed",
                    []
                ];
            }
        } catch(\Exception $e){
            // Rollback transaction on PDOException
            DB::rollBack();
            return [
                $e->getCode(),
                // $e->getMessage(),
                "Something went wrong",
                []
            ];
        }
    }
}
