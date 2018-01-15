<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Cart;

class InitSeeder extends Seeder {
   public function run() 
   {
      $users = [
         [
            "id"=>1, 
            "username" => "Torch", 
            "first_name" => "Ján",
            "last_name" => "Krnáč",
            "password" => Hash::make('123456'),
            "admin" => 1,
            "email" => "gtorch@gmail.com",
         ]   
      ];

      $carts = [
         [
            "id"=>1, 
            "name" => "from posts", 
            "albumable_id" => 1,
            "albumable_type" => "App\\User",
            "hash" => "abcde",
         ]   
      ];

      if (!User::find(1)){
         foreach ($users as $user) 
         {
            User::create($user);
         }

         foreach ($carts as $cart) 
         {
            Caer::create($album);
         } 
      } 
   }

}