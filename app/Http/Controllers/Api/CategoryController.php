<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Repository\CategoryRepositoryInterface;
use App\Http\Requests\Categories\CategoryRequest;
use App\Http\Requests\Categories\CategoryStoreRequest;
use App\Http\Requests\Categories\CategoryUpdateRequest;

class CategoryController extends Controller
{

     protected $CategoryRepository;

     public function __construct(CategoryRepositoryInterface $CategoryRepository)
     {
         $this->CategoryRepository = $CategoryRepository;
     }

    public function index()
    {
        $this->authorize('viewAny',Category::class);
        return $this->CategoryRepository->Get_allGategory();

    }

    public function show(Category $category)
    {
        $this->authorize('view',$category);
        return $this->CategoryRepository->Get_Gategory($category);
    }

    public function store(CategoryStoreRequest $request)
    {
        $this->authorize('create',Category::class);
        return $this->CategoryRepository->store_Gategory($request);
    }


    public function update(CategoryUpdateRequest $request,Category $category)
    {
        $this->authorize('update',Category::class);
        return $this->CategoryRepository->update_Gategory($request,$category);
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete',Category::class);
        return $this->CategoryRepository->delete_Gategory($category);
    }
}
