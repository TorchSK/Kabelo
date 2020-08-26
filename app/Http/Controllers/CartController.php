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
        $data['bodyid'] = 'cartproducts';
        return view('cart.products', $data);

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
            'payment' => $payment,
            'bodyid' => 'body_cart_delivery'
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

        $data['bodyid'] = 'cart_shipping';
        
        return view('cart.shipping',$data);
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
            $cart = json_decode(Cookie::get('cart'), true);
            $price = 0;

            if ($cart)
            {
                foreach($cart['items'] as $productid)
                {
                    $price = $price + $this->getUserProductPrice($productid, $cart['counts'][$productid]);
                }

                $cart['price'] = $price;

                return $cart;

            }
            else
            {
                return null;
            }
        }
        
        return $cart;
    }

    public function set(Request $request)
    {        

        if (Auth::check())
        {
            $user = Auth::user();
            $cart = $this->getCart($user->cart->id);

            foreach ($request->except('_token') as $key => $item) {
                 $cart[$key] = $item;
            }        

            unset($cart['number']);
            unset($cart['items']);
            $cart->save();
        }
        else
        {
            $cart = $this->getCart('undefined');

            foreach ($request->except('_token') as $key => $item) {
                 $cart[$key] = $item;
            }        

            Cookie::queue('cart', json_encode($cart), 555555);
        }
    }


    public function getUserProductPrice($productId, $qty)
    {
        $user = Auth::user();
        $product = Product::find($productId);

        $levels = $product->priceLevels->pluck('threshold')->toArray();

        foreach ($levels as $key => $level) 
        {
            if(!isset($levels[$key+1])) $levels[$key+1] = '999999';
            
            if ($qty >= $level && $qty < $levels[$key+1]) 
            {
                $closest = $level;
            }
        }
    
        if (Auth::check())
        {
            if($user->voc)
            {
                if ($product->sale)
                {
                    $price = $product->priceLevels->where('threshold', $closest)->first()->voc_sale * (1-$user->discount/100);
                }
                else
                {
                    $price = $product->priceLevels->where('threshold', $closest)->first()->voc_regular * (1-$user->discount/100);;
                }
            }
            else
            {
                if ($product->sale)
                {
                    $price = $product->priceLevels->where('threshold', $closest)->first()->moc_sale * (1-$user->discount/100);;
                }
                else
                {
                    $price = $product->priceLevels->where('threshold', $closest)->first()->moc_regular * (1-$user->discount/100);
                }   
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
            $cartCount = $cart->products->count();
            $pivot = [];


            if (! $cart->products->contains($product->id))
            {   
                if($request->has('size'))
                {
                    $sizes = [];
                    array_push($sizes, $request->get('size'));
                    $pivot['sizes'] = json_encode($sizes);
                }

                $pivot['qty'] = $request->get('qty');
                $pivot['price_level_id'] = $this->getPriceLevel($productId, $request->get('qty'));

                $cart->products()->attach($product, $pivot);
                $cartCount =  $cartCount +1;

            }
            else
            {
                if($request->has('size'))
                {
                    $sizes = json_decode($cart->products->where('id',$productId)->first()->pivot->sizes);
                    array_push($sizes, $request->get('size'));  
                    $pivot['sizes'] = json_encode($sizes);
                }
                
                $oldQty = $cart->products->where('id',$productId)->first()->pivot->qty;
                $pivot['qty'] = $oldQty + $request->get('qty');
                $pivot['price_level_id'] = $this->getPriceLevel($productId, $oldQty + $request->get('qty'));

                $cart->products()->updateExistingPivot($product->id, $pivot);
            }

            

        }
        else
        {

            $cartNumber = $cart['number'];
            $cartPrice = $cart['price'];
            $cartItems = $cart['items'];
            $cartCounts = $cart['counts'];
            $cartSizes = $cart['sizes'];
            $cartPriceLevels = $cart['price_levels'];
            $cartCount = count($cartCounts);


            $cartData = $cart;

            if (!in_array($productId, $cart['items']))
            {
                array_push($cartItems,$productId);
                $cartData['number'] = $cartNumber + 1;
                $cartCounts[$productId]=$request->get('qty');
                $cartPriceLevels[$productId]=$this->getPriceLevel($productId, $request->get('qty'));
                $cartCount = $cartCount + 1;

                if($request->has('size'))
                {
                  $cartSizes[$productId]=[$request->get('size')];
                }
            }
            else
            {
                $oldQty = $cartCounts[$productId];
                $cartData['number'] = $cartNumber ;
                $cartCounts[$productId]=$oldQty + $request->get('qty');
                $cartPriceLevels[$productId] = $this->getPriceLevel($productId, $oldQty+ $request->get('qty'));

                if($request->has('size'))
                {
                    array_push($cartSizes[$productId], $request->get('size'));
                }


            }

            $cartData['price'] = $cartPrice + $price;
            $cartData['items'] = $cartItems;
            $cartData['counts'] = $cartCounts;
            $cartData['price_levels'] = $cartPriceLevels;

            if($request->has('size'))
            {
                $cartData['sizes'] = $cartSizes;
            }

            Cookie::queue('cart', $cartData, config('app.cartCookieExpire'));
        }

        // return price for FE
        $data['price'] = $price;
        $data['count'] = $cartCount;
        $data['product'] = $product;
        
        $data['row'] = view('cart.row', $data)->render();

        return $data;
    }

    public function setItem($cartid, $productid, Request $request)
    {
        $product = Product::find($productid);
        
        $cart = $this->getCart($cartid);
        $price = $this->getUserProductPrice($productid, $request->get('qty'));

        if (Auth::check())
        {
            $cart->products()->updateExistingPivot($product->id, ['qty'=>$request->get('qty'), 'price_level_id' => $price = $this->getPriceLevel($productid, $request->get('qty'))]);
        }
        else
        {   

            $cart['counts'][$productid] = $request->get('qty');
            $cart['price_levels'][$productid] = $this->getPriceLevel($productid, $request->get('qty'));

            Cookie::queue('cart', $cart, config('app.cartCookieExpire'));
        }

        return $cart;
    }

    public function deleteItem($cartid, $productId)
    {
        $product = Product::find($productId);
        
        $cart = $this->getCart($cartid);
        


        if (Auth::check())
        {
            $cart->products()->detach($product);
        }
        else
        {
            $price = $this->getUserProductPrice($productId, $cart['counts'][$productId]);
            
            if (($key = array_search($productId, $cart['items'])) !== false) {
                unset($cart['items'][$key]);
            }
            
            $cart['number'] = $cart['number']-1;
            $cart['price'] = $cart['price'] - $price;

            if ($cart['price'] < 0.0001) $cart['price'] = 0;

            unset($cart['counts'][$productId]);
            unset($cart['price_levels'][$productId]);

            Cookie::queue('cart', $cart, config('app.cartCookieExpire'));
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
            Cookie::queue('cart', $cartData, config('app.cartCookieExpire'));
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
