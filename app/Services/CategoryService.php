<?php 

namespace App\Services;

use App\Services\Contracts\CategoryServiceContract;

use App\Category;

use Hash;
use Session;
use Auth;
use Cookie;
use Cache;

class CategoryService implements CategoryServiceContract {


  public function __construct ()
  {
  }

  public function getCategories()
  { 

      if(!Cache::has('categories'))
      {
        $categories = Category::with('descendants')->orderBy('order')->get()->toTree();
        Cache::put('categories', $categories, 60);
      }
      else
      {
        $categories = Category::with('descendants')->orderBy('order')->get()->toTree();
      }
      return $categories;
  }

    public function getCategoriesRaw()
  { 

      if(!Cache::has('categories'))
      {
        $categories = Category::with('descendants')->withDepth()->orderBy('order')->get();
        Cache::put('categories', $categories, 60);
      }
      else
      {
        $categories = Category::with('descendants')->withDepth()->orderBy('order')->get();
      }
      return $categories;
  }
 
 
}