<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class User extends Seeder
{
    public function run()
    {
        $userModel = new \App\Models\UsersModel();

        $users = $this->generateUsers();

        // Insert users
        $userModel->insertBatch($users);
    }

    function generateUsers(){
        $faker = Factory::create();
        $data = [];
        for ($i = 0; $i < 10000; $i++) {
            $data[] = [
                'username' => $faker->username,
                'first_name' => $faker->first_name,
                'last_name' => $faker->last_name,
                'phone' => $faker->phone,
                'email' => $faker->email,
            ];
        }
        return $data;
    }
}
