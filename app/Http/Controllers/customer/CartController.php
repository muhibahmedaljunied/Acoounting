<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Product;
use App\Cart;

class CartController extends Controller
{

    public function index()
    {
        
    }

    // -----------------------------
    public function addToCart($id,$cartQty) {


        if (session()->has('cart')) {
            $cart = new Cart(session()->get('cart'));
        } else {
            $cart = new Cart();
        }

        $product = Product::find($id);
       

        $cart->add($product,$cartQty);
        session()->put('cart', $cart);
        
        return response()->json([
                    'result'=>session()->get('cart')
        ]);
    }

//     php artisan tinker
// // then
// factory(\App\User::class,10)->create()
    // -----------------------------


    public function allCart(){
        
        if(session()->has('cart')){

            $cart = new Cart(session()->get('cart'));

        }else{

            $cart = 0;
        }


        return response()->json([
            'cart' => $cart,
            // 'session' => session()->get('cart'),
            'count_cart'=>$cart->totalQty,
            'subtotal' => $cart->totalPrice
            ]);
        
    }

    public function deleteCart(Request $request){
        
        $cart = new Cart(session()->get('cart'));
        $cart->remove($request->post('id'));
        session()->put('cart', $cart);

        return response()->json(['success'=>'product deleted from cart']);

    }

    public function updateCart(Request $request){

        $cart = new Cart(session()->get('cart'));
        $cart->updateQty($request->post('id'),$request->post('qty'));
        return response()->json($request);

    }

    public function getFeaturedProducts(){
    	$featuredProduct = Product::where('status',1)
    					->limit(3)
    					->get();

    	//return $featuredProduct;
    	return response()->json($featuredProduct);
    }

    public function getNewProducts(){
    	$newProduct = Product::where('status', 1)
    				->orderBy('id', 'desc')
    				->limit(8)
    				->get();
    	//return $featuredProduct;
    	return response()->json($newProduct);
    }

}
