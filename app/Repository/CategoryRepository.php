<?php
namespace App\Repository;

use App\Models\Category;
use App\Traits\ApiResposeTrait;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Http\Requests\Categories\CategoryStoreRequest;
use App\Models\User;

class CategoryRepository implements CategoryRepositoryInterface{
    use ApiResposeTrait;

    public function Get_allGategory()
    {
        $categories = Category::whereNull('parent_id')->orWhereHas('child')->with('child','products')->get();
        return $this->successResponse(new CategoryCollection($categories),'success',200);
    }

    public function Get_Gategory($category)
    {
        $id = $category->id;
        $category = Category::with('child', 'products')->find($id);
        return $this->successResponse(CategoryResource::make($category),'success',200);
    }

    public function store_Gategory($request)
    {
        $category = new Category();
        $category->name = $request->input('name');
        $category->parent_id = $request->input('parent_id');

        $category->save();

        return $this->successResponse(CategoryResource::make($category),'success',200);
    }

    public function update_Gategory($request,$category)
    {
        $id = $category->id;
        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->parent_id = $request->input('parent_id');

        $category->save();

        return $this->successResponse(CategoryResource::make($category), 'success', 200);
    }
    public function delete_Gategory($category)
    {
        $category->delete();

        return $this->successResponse('null','Category deleted successfully', 200);
    }
}

