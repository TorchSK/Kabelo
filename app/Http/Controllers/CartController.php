<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Parameter;
use App\Cart;
use App\File as ProductFile;
use App\PriceLevel;
use App\Setting;

use App\Services\Contracts\CartServiceContract;

use Image;
use File;
use Cookie;
use Auth;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        CartServiceContract $cartService
    )
    {
        $this->cartService = $cartService;
    }

    public function products(){
        return view('cart.products');
    }

    public function delivery(){
        $cookie = Cookie::get('cart');

        if (isset($cookie['delivery']))
        {
            $delivery =  $cookie['delivery'];
        }
        else
        {
            $delivery =  -1;
        }

        if (isset($cookie['payment']))
        {
            $payment =  $cookie['payment'];
        }
        else
        {
            $payment =  -1;
        }


        $data = [
            'delivery' => $delivery,
            'payment' => $payment
        ];

        return view('cart.delivery', $data);
    }

    public function shipping(){
        if (Auth::check())
        {
            $cart = $this->getCart(Auth::user()->cart->id);
        }
        else
        {
            $cart = $this->getCart('undefined');
        }

        if ($cart['price'] < Setting::whereName('min_order_price')->first()->value)
        {
             return redirect('cart/products');

        }
        return view('cart.shipping');
    }


   public function confirm(){

        return view('cart.confirm');
    }

    function getCart($id)
    {
        if ($id!='undefined')
        {
            $cart = Cart::find($id);
            $cart['number'] = $cart->products->count();
            $cart['items'] = $cart->products->pluck('id')->toArray();

            $price = 0;
            foreach($cart->products as $product)
            {
                $price = $price + $this->getUserProductPrice($product->id, $product->pivot->qty);
            }

            $cart['price'] = $price;

        }
        else
        {
            $cart = Cookie::get('cart');
        }
        
        return $cart;
    }

    public function set(Request $request)
    {        
        $userid = Auth::user()->id;
        $cart = $this->getCart($userid);

        foreach ($request->except('_token') as $key => $item) {
          $cart[$key] = $item;
        }        

        if (Auth::check())
        {
            unset($cart['number']);
            unset($cart['items']);
            $cart->save();
        }
        else
        {
            Cookie::queue('cart', $cart, 0);
        }
    }

    public function getUserProductPrice($productId, $qty)
    {
        $user = Auth::user();
        $product = Product::find($productId);

        $levels = $product->priceLevels->pluck('threshold');

        $closest = null;
        foreach ($levels as $level) 
        {
            if ($closest === null || abs($qty - $closest) > abs($level - $qty)) 
            {
                $closest = $level;
            }
        }
    
        if (Auth::check() && $user->voc)
        {
            if ($product->sale)
            {
                $price = $product->priceLevels->where('threshold', $closest)->first()->voc_sale;
            }
            else
            {
                $price = $product->priceLevels->where('threshold', $closest)->first()->voc_regular;
            }
        }
        else
        {
            if ($product->sale)
            {
                $price = $product->priceLevels->where('threshold', $closest)->first()->moc_sale;
            }
            else
            {
                $price = $product->priceLevels->where('threshold', $closest)->first()->moc_regular;
            }   
        }

        return $price*$qty;     

    }

    public function getPriceLevel($productId, $qty)
    {
        $user = Auth::user();
        $product = Product::find($productId);

        $levels = $product->priceLevels->pluck('threshold')->toArray();
        sort($levels);

        $index=0;
        foreach($levels as $key => $level) 
        {
          if($qty >= $level) 
          {
            $index = $key;
          }
        }
        
        $id = $product->priceLevels()->where('threshold',$levels[$index])->first()->id;

        return $id;   

    }

    public function addItem($cartid, $productId, Request $request)
    {
        $product = Product::find($productId);

        $cart = $this->getCart($cartid);
        $price = $this->getUserProductPrice($productId, $request->get('qty'));

        if (Auth::check())
        {   
            if (! $cart->products->contains($product->id))
            {
                $cart->products()->attach($product, ['qty'=>$request->get('qty'), 'price_level_id'=>$this->getPriceLevel($productId, $request->get('qty'))]);
            }
            else
            {
                $oldQty = $cart->products->where('id',$productId)->first()->pivot->qty;
                $cart->products()->updateExistingPivot($product->id, ['qty'=>$oldQty + $request->get('qty'), 'price_level_id' => $this->getPriceLevel($productId, $oldQty + $request->get('qty'))]);
            }

            $cartCount = $cart->products->count();

        }
        else
        {

            $cartNumber = $cart['number'];
            $cartPrice = $cart['price'];
            $cartItems = $cart['items'];
            $cartCounts = $cart['counts'];
            $cartPriceLevels = $cart['price_levels'];


            $cartData = $cart;

            if (!in_array($productId, $cart['items']))
            {
                array_push($cartItems,$productId);
                $cartData['number'] = $cartNumber + 1;
                $cartCounts[$productId]=$request->get('qty');
                $cartPriceLevels[$productId]=$this->getPriceLevel($productId, $request->get('qty'));

            }
            else
            {
                $oldQty = $cartCounts[$productId];
                $cartData['number'] = $cartNumber ;
                $cartCounts[$productId]=$oldQty + $request->get('qty');
                $cartPriceLevels[$productId] = $this->getPriceLevel($productId, $oldQty+ $request->get('qty'));
            }

            $cartData['price'] = $cartPrice + $price;
            $cartData['items'] = $cartItems;
            $cartData['counts'] = $cartCounts;
            $cartData['price_levels'] = $cartPriceLevels;

            $cartCount = count($cartCounts);
            Cookie::queue('cart', $cartData, 0);
        }

        // return price for FE
        $data['price'] = $price;
        $data['count'] = $cartCount;
        return $data;
    }

    public function setItem($cartid, $productid, Request $request)
    {
        $product = Product::find($productid);
        
        $cart = $this->getCart($cartid);

        if (Auth::check())
        {
            $cart->products()->updateExistingPivot($product->id, ['qty'=>$request->get('qty'), 'price_level_id' => $this->getPriceLevel($productid, $request->get('qty'))]);
        }
        else
        {
            Cookie::queue('cart', $cartData, 0);
        }

        return $cart;
    }

    public function deleteItem($cartid, $productId)
    {
        $product = Product::find($productId);
        
        $cart = $this->getCart($cartid);

        $cartNumber = $cart['number'];
        $cartPrice = $cart['price'];
        $cartItems = $cart['items'];

        $itemCount = array_count_values($cartItems)[$productId];

        foreach (array_keys($cartItems, $productId) as $key) {
            unset($cartItems[$key]);
        }

        $cartData =  $cart ;
        $cartData['number'] = $cartNumber - $itemCount;
        $cartData['price'] = $cartPrice - $itemCount*$product->price;
        $cartData['items'] = $cartItems;
        
        if (Auth::check())
        {
            $cart->products()->detach($product);
        }
        else
        {
            Cookie::queue('cart', $cartData, 0);
        }

        // return price for FE
        $data['price'] = $product->price;
        return $data;
    }


    public function minusItem($productId)
    {
        $product = Product::find($productId);

        $cart = $this->getCart();

        $cartNumber = $cart['number'];
        $cartPrice = $cart['price'];
        $cartItems = $cart['items'];
        
        $itemCount = array_count_values($cartItems)[$productId];

        $minusItemKey = array_keys($cartItems, $productId)[0];
        unset($cartItems[$minusItemKey]);

        $cartData = $cart;

        $cartData['number'] = $cartNumber - 1;
        $cartData['price'] = $cartPrice - $product->price;
        $cartData['items'] = $cartItems;
        
        if (Auth::check())
        {
            $cart->products()->sync([]);
            foreach ($cartData['items'] as $item)
            {
                $cart->products()->attach($item);
            }
        }
        else
        {
            Cookie::queue('cart', $cartData, 0);
        }

        // return price for FE
        $data['price'] = $product->price;
        return $data;
    }


    public function delete()
    {
        return $this->cartService->delete();  
    }
}
