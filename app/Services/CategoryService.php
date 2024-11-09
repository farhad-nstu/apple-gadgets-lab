<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;

class CategoryService
{
    use ResponseTrait;

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategoryList(){
        try{
            $categoryList = $this->categoryRepository->getCategoryList();
            if($categoryList) {
                return [
                    Response::HTTP_OK,
                    "Category list get successfully",
                    $categoryList
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
    public function storeCategory(array $request) : array
    {
        try{
            $categoryData = $this->categoryRepository->store($request);
            if($categoryData) {
                return [
                    Response::HTTP_OK,
                    "Category data stored successfully",
                    $categoryData
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
