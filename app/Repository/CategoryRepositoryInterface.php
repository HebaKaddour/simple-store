<?php

namespace App\Repository;

interface CategoryRepositoryInterface{

    public function Get_allGategory();
    public function Get_Gategory($category);
    public function store_Gategory($request);
    public function update_Gategory($request,$category);
    public function delete_Gategory($category);
}

