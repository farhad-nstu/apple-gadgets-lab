<?php

namespace App\Repositories;

use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository
{
    protected Model $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getCategoryList(){
        try {
            return $this->model->all();
        } catch (\Throwable $th) {
            throw new Exception("Database connectivity problem or query problem", 500);
        }
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public function store(array $data) : Model
    {
        try {
            $categoryData = [
                'name' => $data['name'] ?? null
            ];

            return $this->model->create($categoryData);

        } catch (\PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage(), 500);
        } catch (\Exception $e) {
            throw new Exception("An unexpected error occurred: " . $e->getMessage(), 500);
        }
    }
}
