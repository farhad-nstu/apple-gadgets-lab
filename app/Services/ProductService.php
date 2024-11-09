<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;

class ProductService
{
    use ResponseTrait;

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProductList($request){
        try{
            $productList = $this->productRepository->getProductList($request);
            if($productList) {
                return [
                    Response::HTTP_OK,
                    "Product found successfully",
                    $productList
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

    public function storeProduct(array $request) : array
    {
        try{
            $productData = $this->productRepository->storeProduct($request);
            if($productData) {
                return [
                    Response::HTTP_OK,
                    "Product saved successfully",
                    $productData
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

    public function updateProduct(array $request, $id) : array
    {
        try{
            $productData = $this->productRepository->updateProduct($request, $id);
            if($productData) {
                return [
                    Response::HTTP_OK,
                    "Product updated successfully",
                    $productData
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

    public function deleteProduct($id)
    {
        try{
            $product = $this->productRepository->deleteProduct($id);
            if($product) {
                return [
                    Response::HTTP_OK,
                    "Product deleted successfully",
                    $product
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
