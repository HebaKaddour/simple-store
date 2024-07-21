<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Repository\ProductRepository;
use App\Http\Requests\Products\ProductStoreRequest;
use App\Http\Requests\Products\ProductUpdateRequest;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $this->authorize('viewAny',Product::class);
        return $this->productRepository->Get_allProduct();
    }

    public function show(Product $product)
    {
        $this->authorize('view',$product);
        return $this->productRepository->Get_Product($product);
    }

    public function store(ProductStoreRequest $request)
    {
        $this->authorize('create',Product::class);
        return $this->productRepository->store_Product($request);
    }

    public function update(ProductUpdateRequest $request,Product $product)
    {
        $this->authorize('update',Product::class);
        return $this->productRepository->update_Product($request, $product);
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete',Product::class);
       return $this->productRepository->delete_Product($product);
    }
}
