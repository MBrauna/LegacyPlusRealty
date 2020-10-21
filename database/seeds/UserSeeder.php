<?php

use Illuminate\Database\Seeder;
use App\Models\UserType;
use App\Models\TransactionType;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionType::create([
            'id_transaction_type'   =>  1,
            'description'           =>  'Salle',
            'status'                =>  true,
        ]);

        TransactionType::create([
            'id_transaction_type'   =>  2,
            'description'           =>  'Rental',
            'status'                =>  true,
        ]);

        UserType::create([
            'id_user_type'  =>  1,
            'description'   =>  'Admin',
            'status'        =>  true
        ]);

        UserType::create([
            'id_user_type'  =>  2,
            'description'   =>  'Realtor',
            'status'        =>  true
        ]);

        UserType::create([
            'id_user_type'  =>  3,
            'description'   =>  'Broker',
            'status'        =>  true
        ]);

        User::create([
            'name'          =>  'Michel Brauna Rodrigues',
            'email'         =>  'eu@mbrauna.com',
            'password'      =>  Hash::make('ABC123abc.'),
            'id_user_type'  =>  1,
        ]);

        User::create([
            'name'          =>  'Giselle Nunes Baptista',
            'email'         =>  'giselle.nb@gmail.com',
            'password'      =>  Hash::make('ABC123abc.'),
            'id_user_type'  =>  1,
        ]);
    }
}
