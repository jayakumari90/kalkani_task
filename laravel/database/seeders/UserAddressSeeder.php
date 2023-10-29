<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Hash;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        // following line retrieve all the user_ids from DB
        $users = User::all()->pluck('id');
        foreach(range(1,50) as $index){
            UserAddress::create([
                'user_id'=>$faker->randomElement($users),
                'address_line1' => $faker->streetName,
                'address_line2'=>$faker->streetAddress,
                'pincode'=>$faker->postcode,
                'city'=>$faker->city,
                'state'=>$faker->state,
                'address_type'=>'HOME',
                'status'=>1
            ]);
        }
    }
}
