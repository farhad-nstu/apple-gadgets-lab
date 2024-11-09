<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Services\ProductService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    use ResponseTrait;

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getProductList(Request $request){
        try{
            [$code, $message, $data] = $this->productService->getProductList($request);
            if($code === Response::HTTP_OK){
                return $this->success($data, $message, $code);
            }
            return $this->error($message, null, $code, $data);
        } catch(\Exception $e){
            return $this->error('Something went wrong!', $e->getTrace(), 500);
        }
    }

    public function storeProduct(ProductStoreRequest $request)
    {
        try{
            [$code, $message, $data]  = $this->productService->storeProduct($request->all());
            if($code === Response::HTTP_OK){
                return $this->success($data, $message, $code);
            }
            return $this->error($message, null, $code, $data);
        }catch(\Exception $e){
            return $e->getMessage();
            return $this->error('Something went wrong!', $e->getTrace(), 500);
        }
    }

    public function updateProduct(ProductUpdateRequest $request, $id)
    {
        try{
            [$code, $message, $data]  = $this->productService->updateProduct($request->all(), $id);
            if($code === Response::HTTP_OK){
                return $this->success($data, $message, $code);
            }
            return $this->error($message, null, $code, $data);
        }catch(\Exception $e){
            return $e->getMessage();
            return $this->error('Something went wrong!', $e->getTrace(), 500);
        }
    }

    public function deleteProduct($id)
    {
        try{
            [$code, $message, $data]  = $this->productService->deleteProduct($id);
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
