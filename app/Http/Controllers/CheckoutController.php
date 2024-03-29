<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::with('product')
            ->where('cart_id' , App::make('cart.id'))
            ->get();

        $total = $cart->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('front.checkout', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'first_name' => 'required|string',
        //     'last_name'  => 'required|string',
        // ]);

        $cart = Cart::with('product')
            ->where('cart_id' , App::make('cart.id'))
            ->get();

        $total = $cart->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        if ($cart->count() == 0)
        {
            return redirect('/');
        }

        DB::beginTransaction();

        try {

            if ($request->post('register')) {
                $user = $this->createUser($request);
            }

            $request->merge([
                'user_id' => Auth::id(),
                'total' => $total,
            ]);


            $order = Order::create($request->all());

            foreach ($cart as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price, 
                ]);
            }
            //Cart::where('cart_id',App::make('cart.id'))->delete();

            Cart::where('cart_id' , App::make('cart.id'))->delete();

            DB::commit();
            
            return redirect('/')->with('status', 'Thank you!, The order has been placed!');

        } catch (Throwable $e) {
            DB::rollBack();

            return redirect()
                    ->back()
                    ->with('error', $e->getMessage())
                    ->withInput();
        }


    }

    protected function createUser(Request $request)
    {
        $data = [
            'name' => $request->fisrt_name . ' ' . $request->last_name,
            'password' => Str::random(8),
            'email' => $request->email,
            'terms' => 1,
        ];

        $creator = new CreateNewUser();
        $user = $creator->create($data);
        Auth::login($user);

        return $user;
    }
}
