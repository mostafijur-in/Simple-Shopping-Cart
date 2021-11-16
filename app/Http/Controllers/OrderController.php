<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

use Exception;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Orders   = Order::paginate(30);
        return view('admin.orders.orders', compact('Orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    /**
     * View cart
     *
     * @return \Illuminate\Http\Response
     */
    public function cart()
    {
        return view('cart');
    }

    /**
     * Add product to cart
     *
     * @return \Illuminate\Http\Response
     */
    public function addToCart(Request $request)
    {
        $id = $request->product_id;
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "photo" => $product->photo
            ];
        }

        session()->put('cart', $cart);

        $cartUrl    = route('cart');
        $homeUrl    = route('home');

        return json_encode([
            "status"    => "success",
            "message"   => "<p class=\"text-success mb-2\">Product added to cart successfully!</p><a href=\"{$cartUrl}\" class=\"btn btn-info btn-sm mr-2\">Go to Cart</a> <a href=\"{$homeUrl}\" class=\"btn btn-success btn-sm me-2\">Continue shopping</a>",
        ]);
    }

    /**
     * Update cart
     *
     * @return \Illuminate\Http\Response
     */
    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);

            return json_encode([
                'status'    => 'success',
                'message'   => 'Cart updated successfully!'
            ]);
        }
    }

    /**
     * Remove product from cart
     *
     * @return \Illuminate\Http\Response
     */
    public function removeFromCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }

            return json_encode([
                'status'    => 'success',
                'message'   => 'Product removed from cart!'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request)
    {
        $user   = Auth::user();
        $result = [];

        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('cart');
        }

        $orderItems = [];
        $orderTotal = 0;

        try {
            $order  = Order::create([
                'user_id'   => $user->id,
                'order_status'  => 'pending',
                'order_total'   => 0.00,
            ]);

            if($order) {
                foreach($cart as $product_id => $item) {
                    OrderItem::create([
                        'order_id'  => $order->order_id,
                        'product_id'  => $product_id,
                        'qty'   => $item["quantity"],
                        'price' => $item["price"],
                    ]);

                    $orderTotal += $item["quantity"] * $item["price"];
                }

                $order->order_total = $orderTotal;
                $order->save();
            }

            $result = [
                'status'    => 'success',
                'message'   => 'Your order has been placed successfully.',
            ];


            // Unset cart from session
            session()->forget('cart');
        } catch (Exception $e) {
            $result = [
                'status'    => 'error',
                'message'   => 'Unable to place your order.<br />'. $e->getMessage(),
            ];
        }

        return view('checkout', compact('result'));
    }
}
