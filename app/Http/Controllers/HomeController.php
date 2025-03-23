<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index(){
        $user=user::where('usertype','user')->get()->count();
        $product=Product::all()->count();
        $order=Order::all()->count();
        $status=Order::where('status','Delivered')->count();
        return view('admin.index',compact('user','product','order','status'));
    }

    public function Home(){
        $data=Product::all();
        if(Auth::id()){
        $user=Auth::user();
        $userid=$user->id;
        $count = Cart::where('user_id', $userid)->count();
        }
        else{
            $count=null;
        }
        return view('home.index',compact('data','count'));
    }

    public function login_home(){
        $data=Product::all();
        if(Auth::id()){
            $user=Auth::user();
            $userid=$user->id;
            $count = Cart::where('user_id', $userid)->count();
            }
            else{
                $count=null;
            }

        return view('home.index',compact('data','count'));
    }

    public function product_details($id){
        $data=Product::find($id);
        if(Auth::id()){
            $user=Auth::user();
            $userid=$user->id;
            $count = Cart::where('user_id', $userid)->count();
            }
            else{
                $count=null;
            }
        return view('home.product_details',compact('data','count'));
    }
    public function add_cart($id){
        $product_id=$id;
        $user=Auth::user();
        $used_id = $user->id;
        $data= new Cart;
        $data->user_id= $used_id;
        $data->product_id= $product_id;
        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Product Added to the card Sucessfully.');
        return redirect()->back();
    }
    public function mycart(){
        if (Auth::check()) {
            $user = Auth::user();
            $userid = $user->id;
    
            $count = Cart::where('user_id', $userid)->count();
            $cart = Cart::where('user_id', $userid)->get();
        } else {
            $count = 0; // or null, depending on what you prefer
            $cart = collect(); // return an empty collection if the user is not authenticated
        }
    
        return view('home.mycart', compact('count', 'cart'));
    }
    public function remove_cart($id){
        $remove=Cart::find($id);
        $remove->delete();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Product Successfully removed from the cart.');
        return redirect()->back();
    }

    public function order_data(Request $req)
    {
        // Retrieve input data from the form
        $name = $req->input('name');
        $address = $req->input('address');
        $landmark = $req->input('landmark');
        $phone = $req->input('phone');
        $city = $req->input('city');
        $state = $req->input('state');
        $pincode = $req->input('pin');
        $country = $req->input('country');
        $userid = Auth::id(); // Get the logged-in user's ID
    
        // Fetch the user's cart
        $cart = Cart::where('user_id', $userid)->get();
    
        // Create orders based on cart items
        foreach ($cart as $cart_item) {
            $order = new Order();
            $order->name = $name;
            $order->address = $address;
            $order->landmark = $landmark;
            $order->phone = $phone;
            $order->city = $city;
            $order->state = $state;
            $order->pincode = $pincode;
            $order->country = $country;
            $order->user_id = $userid;
            $order->product_id = $cart_item->product_id;
            $order->transaction_id = "random"; // Replace with actual transaction ID if available
            $order->save();
        }
    
        // Remove items from cart
        Cart::where('user_id', $userid)->delete();
    
        // Fetch updated order data
        $order = Order::where('user_id', $userid)->get();
    
        // Calculate total value of the orders
        $totalValue = 0;
        foreach ($order as $order_item) {
            $totalValue += $order_item->product->price;
        }
    
        // Get count of items in the cart
        $count = $cart->count();
    
        // Pass data to the view
        return view('home.checkout_order', [
            'order' => $order,
            'totalValue' => $totalValue,
            'cart' => $cart,
            'count' => $count
        ]);
    }
    
    

    public function myorders(){
        if(Auth::id()){
            $user=Auth::user();
            $userid=$user->id;
            $count = Cart::where('user_id', $userid)->get()->count();
            }
            else{
                $count=null;
               
            }
            $order=Order::where('user_id',$userid)->get();
        return view('home.order',compact('count','order',));
    }
    
}
