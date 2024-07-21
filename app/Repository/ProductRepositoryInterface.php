<?php

namespace App\Repository;

interface ProductRepositoryInterface{

    public function Get_allProduct();
    public function Get_Product($product);
    public function store_Product($request);
    public function update_Product($request,$product);
    public function delete_Product($product);
}

