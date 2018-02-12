<?php

use Illuminate\Database\Seeder;

use App\Category;

class CategorySeeder extends Seeder {
   public function run() 
   {
      $categories = [
         [
            "id" => 1
            "name"=> "Batérie a nabíjanie", 
            "desc" => "Batérie a nabíjanie", 
         ],
         [
            "id" => 2
            "name"=> "Batérie a nabíjanie", 
            "desc" => "Batérie a nabíjanie", 
         ]
      ];

      Category::truncate();

      foreach ($categories as $category) 
      {
         Category::create($category);
      } 

}