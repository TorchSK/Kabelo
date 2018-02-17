<?php 

namespace App\Services;

use App\Services\Contracts\ProductServiceContract;
use Illuminate\Http\Request;

use App\Category;
use App\Product;

use Hash;
use Session;
use Auth;
use Cookie;
use Response;

class ProductService implements ProductServiceContract {


  public function __construct ()
  {
  }

	public function query($filters, $except=[])
    {


        $result = Product::leftjoin('product_parameters',function($leftjoin){
            $leftjoin->on('product_parameters.product_id', '=', 'products.id');
            })
        ->leftjoin('category_parameters',function($leftjoin){
            $leftjoin->on('category_parameters.id', '=', 'product_parameters.category_parameter_id');
            })
        ->where(function($query) use ($filters, $except){
            foreach ((array)$filters as $key => $temp){
              if ($filters[$key])
              {
                if ($key=='search')
                {   
                    $query->whereRaw("name like '%".$filters['search']."%'");
                }
                elseif($key=='category')
                {
                    $query->whereHas('categories', function($query) use ($filters){
                        $query->where('category_id', $filters['category']);
                    });
                }
                elseif($key=='price')
                {
                    $array = explode(",",$filters['price']);
                    $query->whereBetween('price', $array);

                }
                elseif($key=='parameters')
                {
                    foreach ((array)$filters['parameters'] as $categoryParameter => $value)
                    {
                        if ($categoryParameter == 'makers')
                        {
                             $query->whereIn('maker', $value);
                        }
                        else
                        {
                            $query->whereHas('parameters', function ($query) use ($categoryParameter, $value) {
                                $query->whereIn('value',(array)$value)->whereHas('categoryParameter', function ($query)  use ($categoryParameter, $value){
                                       $query->where('key', $categoryParameter);
                                });
                            }); 
                        }
                   

                    }
                };
              }
            }
        });

        return $result->groupBy(['products.id'])->select(['products.*']);
    }

    public function list(Request $request)
    {
        $filters = $request->get('filters');
        $category = Category::find($request->get('category'));
        $sortBy = $request->get('sortBy');
        $sortOrder = $request->get('sortOrder');    

        if (!$sortBy) {$sortBy = 'name';};
        if (!$sortOrder) {$sortOrder = 'asc';};

        
        // set active filters
        $activeFilters = collect($filters);

        // set products
        $products = $this->query($filters)->orderBy($sortBy,$sortOrder)->get();

        // set price range
        $priceRangeFilters = $filters;
        unset($priceRangeFilters['price']);
        $priceRange = [];
        $priceRange[0] = $this->query($priceRangeFilters)->pluck('price')->min();
        $priceRange[1] = $this->query($priceRangeFilters)->pluck('price')->max();

        $makers = $category->products()->get()->unique(['maker']);

        $categoryParameters = $category->parameters;


        $temp = [];
        $filterCounts['parameters'] = [];

        $filterCounts['parameters']['makers'] = [];
        $filterCountFilters['parameters']['makers'] = [];
        foreach ($makers as $maker)
        {
            $filterCountFilters = $filters;
            
            $filterCountFilters['parameters']['makers'] = [$maker->maker];
            
            $filterCounts['parameters']['makers'][$maker->maker] = $this->query($filterCountFilters)->get()->count();
            
        }


        foreach ($categoryParameters as $categoryParameter)
        {
            $filterCounts['parameters'][$categoryParameter->id] = [];
            $filterCountFilters = $filters;

            foreach ($categoryParameter->parameters as $productParameter)
            {   
                $filterCountFilters['parameters'][$categoryParameter->key] = $productParameter->value;
                array_push($temp, $filterCountFilters);
                $filterCounts['parameters'][$categoryParameter->id][$productParameter->value] = $this->query($filterCountFilters, [$categoryParameter->key])->get()->count();
                unset($filterCountFilters['parameters'][$categoryParameter->key]);
            }
        }

        $data = [
            'makers' => $makers,
            'filters' => $category->parameters,
            'products' => $products,
            'activeFilters' => $activeFilters,
            'filterCounts' => $filterCounts,
            'temp' => $temp,
            'priceRange' => $priceRange
        ];

        return $data;
        //return Response::json(['products' => view('products.list', $data)->render(), 'filters' => view('makers', $data)->render(), 'data' => $data]);
    }
 
}