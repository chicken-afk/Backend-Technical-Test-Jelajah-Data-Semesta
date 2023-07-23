<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = array(
            array(
                "name" => "Admin",
                "email" => "admin@gmail.com",
                "password" => bcrypt("admin123456"),
                "email_verified_at" => date("Y-m-d H:i:s"),
                "role_id" => 1,
                "created_at" => date("Y-m-d H:i:s"),
            ),
            array(
                "name" => "User",
                "email" => "user@gmail.com",
                "password" => bcrypt("user123456"),
                "email_verified_at" => date("Y-m-d H:i:s"),
                "role_id" => 2,
                "created_at" => date("Y-m-d H:i:s"),
            )
        );

        if (User::count() == 0) {
            User::insert($datas);
        }
    }
}
