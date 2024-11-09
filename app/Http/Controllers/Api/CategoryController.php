<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use App\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    use ResponseTrait;

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getCategoryList(){
        try{
            [$code, $message, $data] = $this->categoryService->getCategoryList();
            if($code === Response::HTTP_OK){
                return $this->success($data, $message, $code);
            }
            return $this->error($message, null, $code, $data);
        } catch(\Exception $e){
            return $this->error('Something went wrong!', $e->getTrace(), 500);
        }
    }

    public function storeCategory(CategoryRequest $request)
    {
        try{
            [$code, $message, $data]  = $this->categoryService->storeCategory($request->all());
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
