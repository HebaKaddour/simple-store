<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $roles = [
                ['name' => 'Owner',  'description' => 'Full access to all operations',],
                ['name' => 'Super-admin' , 'description' => 'High-level access to manage users, products, categories, and orders',],
                ['name' => 'Admin','description' => 'Manage users, products, categories, and view orders',],
                ['name' => 'Supervisor','description' => 'Limited access to view users, products, categories, and orders',],
            ];

            DB::table('roles')->insert($roles);
    }
}
