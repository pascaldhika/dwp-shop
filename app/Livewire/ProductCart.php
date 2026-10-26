<?php

namespace App\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Modules\Product\Entities\Product;

class ProductCart extends Component
{
    public $listeners = ['productSelected', 'discountModalRefresh'];

    public $cart_instance;
    public $global_discount;
    public $global_tax;
    public $shipping;
    public $quantity;
    public $check_quantity;
    public $discount_type;
    public $item_discount;
    public $unit_price;
    public $purchase_price;
    public $data;

    private $product;

    public function mount($cartInstance, $data = null)
    {
        $this->cart_instance = $cartInstance;

        if ($data) {
            $this->data = $data;

            $this->global_discount = $data->discount_percentage;
            $this->global_tax = $data->tax_percentage;
            $this->shipping = $data->shipping_amount;

            $this->updatedGlobalTax();
            $this->updatedGlobalDiscount();

            $cart_items = Cart::instance($this->cart_instance)->content();

            foreach ($cart_items as $cart_item) {
                $product_id = $cart_item->id;

                $this->check_quantity[$product_id] = $cart_item->options->stock;
                $this->quantity[$product_id] = $cart_item->qty;
                $this->unit_price[$product_id] = $cart_item->options->unit_price;

                // Purchase price: gunakan nilai tersimpan atau fallback ke unit_price.
                $purchasePrice = $cart_item->options->purchase_price ?? 0;

                if ($purchasePrice == 0) {
                    $purchasePrice = $cart_item->options->unit_price
                        ?? $cart_item->price;
                }

                $this->purchase_price[$product_id] = $purchasePrice;

                $this->discount_type[$product_id] =
                    $cart_item->options->product_discount_type;

                if ($cart_item->options->product_discount_type == 'fixed') {
                    $this->item_discount[$product_id] =
                        $cart_item->options->product_discount;
                } elseif ($cart_item->options->product_discount_type == 'percentage') {
                    $this->item_discount[$product_id] =
                        $cart_item->price > 0
                            ? round(
                                100 * (
                                    $cart_item->options->product_discount
                                    / $cart_item->price
                                )
                            )
                            : 0;
                }
            }
        } else {
            $this->global_discount = 0;
            $this->global_tax = 0;
            $this->shipping = 0.00;
            $this->check_quantity = [];
            $this->quantity = [];
            $this->unit_price = [];
            $this->purchase_price = [];
            $this->discount_type = [];
            $this->item_discount = [];
        }
    }

    public function render()
    {
        $cart_items = Cart::instance($this->cart_instance)->content();

        return view('livewire.product-cart', [
            'cart_items' => $cart_items,
        ]);
    }

    /**
     * Mengambil purchase_price dari request client.
     *
     * Jika kosong, gunakan unit_price.
     * Tidak melakukan perhitungan harga.
     */
    private function resolvePurchasePrice($purchasePrice, $unitPrice)
    {
        if ($purchasePrice === null || $purchasePrice === '') {
            return $unitPrice;
        }

        return $purchasePrice;
    }

    public function productSelected($product)
    {
        $cart = Cart::instance($this->cart_instance);

        $exists = $cart->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id == $product['id'];
        });

        if ($exists->isNotEmpty()) {
            session()->flash('message', 'Product exists in the cart!');

            return;
        }

        $this->product = $product;

        $calculated = $this->calculate($product);

        // Purchase price berasal dari request client jika tersedia.
        // Jika kosong, gunakan unit_price.
        $purchasePrice = $this->resolvePurchasePrice(
            $product['purchase_price'] ?? null,
            $calculated['unit_price']
        );

        $productId = $product['id'];

        $this->unit_price[$productId] = $calculated['unit_price'];
        $this->purchase_price[$productId] = $purchasePrice;

        $cart->add([
            'id'      => $productId,
            'name'    => $product['product_name'],
            'qty'     => 1,
            'price'   => $calculated['price'],
            'weight'  => 1,
            'options' => [
                'product_discount'      => 0.00,
                'product_discount_type' => 'fixed',
                'sub_total'             => $calculated['sub_total'],
                'code'                  => $product['product_code'],
                'stock'                 => $product['product_quantity'],
                'unit'                  => $product['product_unit'],
                'product_tax'           => $calculated['product_tax'],
                'unit_price'            => $calculated['unit_price'],
                'purchase_price'        => $purchasePrice,
            ],
        ]);

        $this->check_quantity[$productId] = $product['product_quantity'];
        $this->quantity[$productId] = 1;
        $this->discount_type[$productId] = 'fixed';
        $this->item_discount[$productId] = 0;
    }

    public function removeItem($row_id)
    {
        Cart::instance($this->cart_instance)->remove($row_id);
    }

    public function updatedGlobalTax()
    {
        Cart::instance($this->cart_instance)
            ->setGlobalTax((integer) $this->global_tax);
    }

    public function updatedGlobalDiscount()
    {
        Cart::instance($this->cart_instance)
            ->setGlobalDiscount((integer) $this->global_discount);
    }

    public function updateQuantity($row_id, $product_id)
    {
        if (
            $this->cart_instance == 'sale'
            || $this->cart_instance == 'purchase_return'
        ) {
            if ($this->check_quantity[$product_id] < $this->quantity[$product_id]) {
                session()->flash(
                    'message',
                    'The requested quantity is not available in stock.'
                );

                return;
            }
        }

        $cart = Cart::instance($this->cart_instance);

        $cart->update($row_id, $this->quantity[$product_id]);

        $cart_item = $cart->get($row_id);

        $purchasePrice = $this->resolvePurchasePrice(
            $cart_item->options->purchase_price ?? null,
            $cart_item->options->unit_price ?? $cart_item->price
        );

        $cart->update($row_id, [
            'options' => [
                'sub_total'             => $cart_item->price * $cart_item->qty,
                'code'                  => $cart_item->options->code,
                'stock'                 => $cart_item->options->stock,
                'unit'                  => $cart_item->options->unit,
                'product_tax'           => $cart_item->options->product_tax,
                'unit_price'            => $cart_item->options->unit_price,
                'purchase_price'        => $purchasePrice,
                'product_discount'      => $cart_item->options->product_discount,
                'product_discount_type' => $cart_item->options->product_discount_type,
            ],
        ]);

        $this->purchase_price[$product_id] = $purchasePrice;
    }

    public function updatedDiscountType($value, $name)
    {
        $this->item_discount[$name] = 0;
    }

    public function discountModalRefresh($product_id, $row_id)
    {
        $this->updateQuantity($row_id, $product_id);
    }

    public function setProductDiscount($row_id, $product_id)
    {
        $cart = Cart::instance($this->cart_instance);
        $cart_item = $cart->get($row_id);

        if ($this->discount_type[$product_id] == 'fixed') {
            $discount_amount = $this->item_discount[$product_id];

            $cart->update($row_id, [
                'price' => (
                    $cart_item->price
                    + $cart_item->options->product_discount
                ) - $discount_amount,
            ]);

            $cart_item = $cart->get($row_id);

            $this->updateCartOptions(
                $row_id,
                $product_id,
                $cart_item,
                $discount_amount
            );
        } elseif ($this->discount_type[$product_id] == 'percentage') {
            $discount_amount = (
                $cart_item->price
                + $cart_item->options->product_discount
            ) * ($this->item_discount[$product_id] / 100);

            $cart->update($row_id, [
                'price' => (
                    $cart_item->price
                    + $cart_item->options->product_discount
                ) - $discount_amount,
            ]);

            $cart_item = $cart->get($row_id);

            $this->updateCartOptions(
                $row_id,
                $product_id,
                $cart_item,
                $discount_amount
            );
        }

        session()->flash(
            'discount_message' . $product_id,
            'Discount added to the product!'
        );
    }

    public function updatePrice($row_id, $product_id)
    {
        $product = Product::findOrFail($product_id);

        $cart = Cart::instance($this->cart_instance);
        $cart_item = $cart->get($row_id);

        $newPrice = $this->unit_price[$product_id];

        $calculated = $this->calculate($product, $newPrice);

        // Purchase price tetap berasal dari client jika tersedia.
        // Jika kosong, fallback ke unit_price.
        $purchasePrice = $this->resolvePurchasePrice(
            $this->purchase_price[$product_id] ?? null,
            $calculated['unit_price']
        );

        $this->purchase_price[$product_id] = $purchasePrice;

        $cart->update($row_id, [
            'price' => $calculated['price'],
        ]);

        $cart->update($row_id, [
            'options' => [
                'sub_total'             => $calculated['sub_total'],
                'code'                  => $cart_item->options->code,
                'stock'                 => $cart_item->options->stock,
                'unit'                  => $cart_item->options->unit,
                'product_tax'           => $calculated['product_tax'],
                'unit_price'            => $calculated['unit_price'],
                'purchase_price'        => $purchasePrice,
                'product_discount'      => $cart_item->options->product_discount,
                'product_discount_type' => $cart_item->options->product_discount_type,
            ],
        ]);
    }

    public function updatePurchasePrice($row_id, $product_id)
    {
        $this->validate([
            'purchase_price.' . $product_id => 'nullable|numeric|min:0',
        ]);

        $cart = Cart::instance($this->cart_instance);

        $cart_item = $cart->get($row_id);

        if (!$cart_item) {
            return;
        }

        $purchasePrice = $this->purchase_price[$product_id] ?? null;

        // Jika kosong, gunakan unit_price.
        if ($purchasePrice === null || $purchasePrice === '') {
            $purchasePrice = $cart_item->options->unit_price
                ?? $cart_item->price;
        }

        // Pertahankan options lain dan perbarui purchase_price saja.
        $options = $cart_item->options->toArray();
        $options['purchase_price'] = $purchasePrice;

        $cart->update($row_id, [
            'options' => $options,
        ]);

        $this->purchase_price[$product_id] = $purchasePrice;
    }

    public function calculate($product, $new_price = null)
    {
        if ($new_price !== null) {
            $product_price = $new_price;
        } else {
            $this->unit_price[$product['id']] = $product['product_price'];

            if (
                $this->cart_instance == 'purchase'
                || $this->cart_instance == 'purchase_return'
            ) {
                $this->unit_price[$product['id']] = $product['product_cost'];
            }

            $product_price = $this->unit_price[$product['id']];
        }

        $price = 0;
        $unit_price = 0;
        $product_tax = 0;
        $sub_total = 0;

        if ($product['product_tax_type'] == 1) {
            $price = $product_price
                + ($product_price * ($product['product_order_tax'] / 100));

            $unit_price = $product_price;

            $product_tax = $product_price
                * ($product['product_order_tax'] / 100);

            $sub_total = $product_price
                + ($product_price * ($product['product_order_tax'] / 100));
        } elseif ($product['product_tax_type'] == 2) {
            $price = $product_price;

            $unit_price = $product_price
                - ($product_price * ($product['product_order_tax'] / 100));

            $product_tax = $product_price
                * ($product['product_order_tax'] / 100);

            $sub_total = $product_price;
        } else {
            $price = $product_price;
            $unit_price = $product_price;
            $product_tax = 0.00;
            $sub_total = $product_price;
        }

        return [
            'price'       => $price,
            'unit_price'  => $unit_price,
            'product_tax' => $product_tax,
            'sub_total'   => $sub_total,
        ];
    }

    public function updateCartOptions(
        $row_id,
        $product_id,
        $cart_item,
        $discount_amount
    ) {
        $purchasePrice = $this->resolvePurchasePrice(
            $cart_item->options->purchase_price ?? null,
            $cart_item->options->unit_price ?? $cart_item->price
        );

        Cart::instance($this->cart_instance)->update($row_id, [
            'options' => [
                'sub_total'             => $cart_item->price * $cart_item->qty,
                'code'                  => $cart_item->options->code,
                'stock'                 => $cart_item->options->stock,
                'unit'                  => $cart_item->options->unit,
                'product_tax'           => $cart_item->options->product_tax,
                'unit_price'            => $cart_item->options->unit_price,
                'purchase_price'        => $purchasePrice,
                'product_discount'      => $discount_amount,
                'product_discount_type' => $this->discount_type[$product_id],
            ],
        ]);

        $this->purchase_price[$product_id] = $purchasePrice;
    }
}