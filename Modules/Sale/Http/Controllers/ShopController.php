<?php

namespace Modules\Sale\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Modules\Sale\Http\Requests\StorePosSaleRequest;

class ShopController extends Controller
{

    public function index() {
        Cart::instance('sale')->destroy();

        return view('sale::shop.index');
    }


    public function store(StorePosSaleRequest $request)
    {
        // Bersihkan cart Laravel
        Cart::instance('sale')->destroy();

        // Masukkan cart dari JavaScript ke Cart Laravel
        foreach ($request->items as $item) {

            $product = Product::findOrFail($item['product_id']);

            Cart::instance('sale')->add([
                'id'   => $product->id,
                'name' => $product->product_name,
                'qty'  => $item['quantity'],
                'price' => $product->product_price,
                'weight'  => 0,

                'options' => [
                    'code' => $product->product_code,
                    'unit_price' => $product->product_price,
                    'sub_total' => $product->product_price * $item['quantity'],
                    'product_discount' => 0,
                    'product_discount_type' => 'fixed',
                    'product_tax' => 0,
                ],
            ]);
        }

        $user = auth()->user();

        if (is_null($user->customer_id) || !$user->customer) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda belum memiliki data customer.'
            ], 422);
        }

        DB::transaction(function () use ($request) {

            $due_amount = $request->total_amount - $request->paid_amount;

            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }            

            $customer = $user->customer;

            $sale = Sale::create([
                'date' => now()->format('Y-m-d'),
                'reference' => 'PSL',

                'customer_id' => $customer->id,
                'customer_name' => $customer->customer_name,

                'tax_percentage' => $request->tax_percentage,
                'discount_percentage' => $request->discount_percentage,

                'shipping_amount' => $request->shipping_amount * 100,
                'paid_amount' => $request->paid_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'due_amount' => $due_amount * 100,

                'status' => 'Completed',
                'payment_status' => $payment_status,
                'payment_method' => $request->payment_method,
                'note' => $request->note,

                'tax_amount' => Cart::instance('sale')->tax() * 100,
                'discount_amount' => Cart::instance('sale')->discount() * 100,
            ]);

            foreach (Cart::instance('sale')->content() as $cart_item) {

                SaleDetails::create([
                    'sale_id' => $sale->id,
                    'product_id' => $cart_item->id,
                    'product_name' => $cart_item->name,
                    'product_code' => $cart_item->options->code,
                    'quantity' => $cart_item->qty,

                    'price' => $cart_item->price * 100,
                    'unit_price' => $cart_item->options->unit_price * 100,
                    'sub_total' => $cart_item->options->sub_total * 100,

                    'product_discount_amount' =>
                        $cart_item->options->product_discount * 100,

                    'product_discount_type' =>
                        $cart_item->options->product_discount_type,

                    'product_tax_amount' =>
                        $cart_item->options->product_tax * 100,
                ]);

                $product = Product::findOrFail($cart_item->id);

                $product->update([
                    'product_quantity' =>
                        $product->product_quantity - $cart_item->qty
                ]);
            }

            Cart::instance('sale')->destroy();

            if ($sale->paid_amount > 0) {

                SalePayment::create([
                    'date' => now()->format('Y-m-d'),
                    'reference' => 'INV/' . $sale->reference,
                    'amount' => $sale->paid_amount,
                    'sale_id' => $sale->id,
                    'payment_method' => $request->payment_method
                ]);
            }
        });

        toast('POS Sale Created!', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil disimpan',
            'redirect' => route('app.shop.index')
        ]);
    }
}
