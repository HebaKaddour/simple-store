<?php
namespace App\Repository;

use App\Models\Product;
use App\Models\Category;
use App\Traits\ApiResposeTrait;
use App\Http\Resources\ProductResource;


class ProductRepository implements ProductRepositoryInterface{
    use ApiResposeTrait;

    public function Get_allProduct()
    {
    $products = Product::with('category')->get();
    return $this->successResponse(ProductResource::collection($products), 'success', 200);
    }

    public function Get_Product($product)
    {
        $id = $product->id;
        $product = Product::with('category')->find($id);
        return $this->successResponse(ProductResource::make($product),'success',200);
    }

    public function store_Product($request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');

        $product->save();

        return $this->successResponse(ProductResource::make($product),'success',200);
    }

    public function update_Product($request,$product)
    {
        $id = $product->id;
        $product = Product::find($id);

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->save();

        return $this->successResponse(ProductResource::make($product), 'success', 200);
    }

    public function delete_Product($product)
    {
        $product->delete();

        return $this->successResponse('null','Product deleted successfully', 200);
    }
}

