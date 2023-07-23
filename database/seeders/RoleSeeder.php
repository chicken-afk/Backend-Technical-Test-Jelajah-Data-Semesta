<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = ["admin", "user"];

        $count = Role::count();
        if ($count == 0) {
            foreach ($datas as $key => $value) {
                Role::create(['id' => $key + 1, 'role_name' => $value]);
            }
        }
    }
}
