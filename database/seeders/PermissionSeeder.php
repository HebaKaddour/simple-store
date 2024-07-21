<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            ['name' => 'user.create'],
            ['name' => 'user.show'],
            ['name' => 'user.read'],
            ['name' => 'user.update'],
            ['name' => 'user.delete'],
            ['name' => 'product.create'],
            ['name' => 'product.show'],
            ['name' => 'product.read'],
            ['name' => 'product.update'],
            ['name' => 'product.delete'],
            ['name' => 'category.create'],
            ['name' => 'category.show'],
            ['name' => 'category.read'],
            ['name' => 'category.update'],
            ['name' => 'category.delete'],
            ['name' => 'order.read'],
            ['name' => 'order.show'],
            ['name' => 'order.update'],
            ['name' => 'order.delete'],
            ['name' => 'permission.update'],
        ]);

}
}
