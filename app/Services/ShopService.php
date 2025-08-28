<?php

namespace App\Services;



use App\Models\Cart;
use \App\Models\Address;
use App\Models\Order;
use \App\Models\Content;
use App\Models\Status;
use DB;
use PHPUnit\Framework\Exception;

class ShopService
{
    public const PERCENT = 'percent';
    public const AMOUNT = 'amount';
    protected int $productId;
    protected int $amount;
    protected $user;
    protected array $items;
    protected int $shippingCost;
    public static function make()
    {
        return new static();
    }

    public function get()
    {
        return Cart::query()
            ->where("user_id", $this->user->id)
            ->whereNot("status", "pending")
            ->get();
    }

    public function show(int $id)
    {
        return Cart::query()
            ->with(["orders.products"])
            ->where("user_id", $this->user->id)
            ->findOrFail($id);
    }
    public function createSingle()
    {
        $setting = getSetting();

        $product = Content::query()
            ->where("type", "product")
            ->findOrFail($this->productId);
        if ($product->stock < $this->amount) {
            throw new \Exception(trans("message.not_enough_stock"));
        }
        $cart = Cart::query()
            ->where("user_id", $this->user->id)
            ->where("status", "pending")
            ->first();

        if ($cart && $cart->type == "multiple") {
            throw new \Exception(trans("message.you_have_uncompleted_orders"));
        }

        if (!$cart) {
            $cart = Cart::query()
                ->create([
                    "user_id" => $this->user->id,
                    "status" => "pending",
                ]);
        }

        $orders = Order::query()
            ->where("cart_id", $cart->id)
            ->get();

        if ($orders->count() == 0) {
            Order::query()
                ->create([
                    "cart_id" => $cart->id,
                    "content_id" => $this->productId,
                    "qty" => $this->amount,
                    "price" => $product["info"]["final_price"],
                    "final_price" => $this->amount * $product["info"]["final_price"],
                    "total_price" => $this->amount * $product["info"]["final_price"],
                ]);
        }
        
        foreach ($orders as $order) {
            if ($order->content_id == $this->productId) {
                if ($this->amount == 0) {
                    $order->delete();
                } else {
                    $order->price = $product["info"]["final_price"];
                    $order->total_price = $this->amount * $product["info"]["final_price"];
                    $order->final_price = $this->amount * $product["info"]["final_price"];
                    $order->qty = $this->amount;
                    $order->save();
                }
            } else {
                Order::query()
                    ->create([
                        "cart_id" => $cart->id,
                        "content_id" => $this->productId,
                        "qty" => $this->amount,
                        "price" => $product["info"]["final_price"],
                        "final_price" => $this->amount * $product["info"]["final_price"],
                        "total_price" => $this->amount * $product["info"]["final_price"],
                    ]);
            }
        }
		
		$orders = $cart->orders;
		if(count($orders) == 0){
			$cart->delete();
			return true;
		}
		$carTotal = $cart->orders->sum("final_price");

		$shipping_cost = $setting->option->shipping_cost;
		
		if(count($orders) > 1){
			foreach($orders as $order){
                $product = Content::find($order['content_id']);
				$cats = $product['parents'];
				if($cats->whereIn('id', $setting->option->curtain_tools)->count() > 0){
					$shipping_cost = $setting->option->shipping_cost_with_rod;
				}
			}
		}
		
        $cart->shipping_cost = $shipping_cost;
        $cart->total_price = $carTotal;
        $cart->final_price = $carTotal + $shipping_cost;
        $cart->save();
        return true;
    }
	
    public function multiple(array $data)
    {
        $cart = Cart::query()
            ->where("user_id", $this->user->id)
            ->where("status", "pending")
            ->first();
        if ($cart) {
            throw new \Exception(trans("message.you_have_uncompleted_orders"));
        }
        return DB::transaction(function () use ($data) {
            $setting = getSetting();

            $width = $data['width'];
            $rod = $data['rod'];
            $length = $data['length'];

            if ($rod == 2 || $length < ($width + 20)) {
                $length = $width + 20;
            }

            if ($data['tool'] == 0) {
                $shipping_cost = $setting->option->shipping_cost;
            } else {
                $shipping_cost = $setting->option->shipping_cost_with_rod;
            }

            $cart = new Cart();
            $cart->shipping_cost = $shipping_cost;
            $cart->total_price = 0;
            $cart->final_price = 0;
            $cart->user_id = $this->user->id;
            $cart->currency = defaultCurrency();
            $cart->tracking_code = null;
            $cart->delivery_date = null;
            $cart->delivery_time = null;
            $cart->address_id = null;
            $cart->description = $data['description'] ?? null;
            unset($data['description']);
            $cart->status = "pending";
            $cart->type = "multiple";
            $cart->info = json_encode($data);
            $cart->save();


            $status = new Status();
            $status->content_type = Cart::class;
            $status->content_id = $cart->id;
            $status->user_id = $cart->user_id;
            $status->status = "pending";
            $status->save();

            $height = 300;
            if ($data['dookht'] != 1 && $data['height'] > 0) {
                $height = $data['height'];
            }

            $sumTotalPrice = 0;
            $sumFinalPrice = 0;

            foreach ($data['orders'] as $o) {
                $order = new Order();
                $product = Content::find($o['id']);
                $order->content_id = $product['id'];
                $order->price = $product['info']['final_price'];
                $order->qty = $o['amount'];

                $price = $product['info']['final_price'] * $o['amount'];

                $order->total_price = $price;

                if ($o['type'] == "tool") {
                    $price = $price * ($length / 100);
                } else {
                    if ($height > 300) {
                        $additionalHeight = $height / 300;
                        $price = $additionalHeight * $price;
                    }
                    if ($data['dookht'] == 2) {
                        $price = $price + $setting->option->minimal_conf;
                    }
                }

                $order->final_price = $price;
                $sumTotalPrice = $sumTotalPrice + $price;

                $order->cart_id = $cart->id;
                $order->type = $o['type'];
                $order->info = null;
                $order->status = "pending";
                $order->save();
            }

            $sumFinalPrice = $sumTotalPrice + $shipping_cost;

            $cart->total_price = $sumTotalPrice;
            $cart->final_price = $sumFinalPrice;
            $cart->save();

            return $cart;
        });
    }

    public function create()
    {
        $cart = Cart::query()
            ->where("user_id", $this->user->id)
            ->where("status", "pending")
            ->first();
        if ($cart) {
            throw new \Exception(trans("message.you_have_uncompleted_orders"));
        }
        $cart = $this->addProductToCart($cart);
        $cart->shipping_cost = $this->shippingCost;
        $totalCost = $cart->total_cost;
        $cart->final_price = $totalCost + $cart->shipping_cost;
        $cart->save();
        return $cart;
    }
    public function addProductToCart($cart)
    {
        $totalCost = 0;
        foreach ($this->items as $item) {
            $product = Content::query()
                ->where("type", "product")
                ->where('stock', '>=', $item->amount)
                ->find($item->product_id);
            if (!$product) {
                throw new Exception('محصول مورد نظر موجودی کافی ندارد');
            }

            $order = Order::query()
                ->where("user_id", $this->user->id)
                ->where("cart_id", $cart->id)
                ->where("content_id", $product->id)
                ->first();
            if ($order) {
                throw new Exception(trans("message.you_have_uncompleted_orders"));
            } else {
                Order::query()
                    ->create([
                        'product_id' => $item->product_id,
                        'qty' => $item->amount,
                        'price' => $product->price,
                        'total_price' => $product->price * $this->amount,
                        'final_price' => $product->price * $this->amount,
                        'cart_id' => $cart->id,
                    ]);
                $totalCost = $totalCost + $order->final_price;
            }
        }
        $cart->total_cost = $totalCost;
        return $cart->refresh();
    }
    public function createCart()
    {
        $address = Address::query()
            ->where('user_id', $this->user->id)
            ->where('is_default', true)
            ->first();
        if (!$address) {
            $address = Address::query()
                ->where('user_id', $this->user->id)
                ->first();
        }
        $cart = Cart::query()
            ->create([
                "address_id" => $address->id ?? null,
                "user_id" => $this->user->id
            ]);
        return $cart;
    }

    public function updateField(int $id, $key, $value)
    {
        $cart = Cart::query()
            ->where('user_id', $this->user->id)
            ->findOrFail($id);
        if ($key == 'delivery') {
            if ($value == null) {
                $cart->update([
                    'delivery_date' => null,
                    'delivery_time' => null
                ]);
            } else {
                list($data, $time) = explode('|', $value);
                $cart->update([
                    'delivery_date' => $data,
                    'delivery_time' => $time
                ]);
            }
        } else {
            $cart->update([
                $key => $value
            ]);
        }
        return $cart->refresh();
    }
    public function delete(int $orderId)
    {
        $order = $this->getOrderById($orderId);
        $cart = $this->getCartByOrder($order);
        $cart->delete();
        return 'deleted successfully';
    }
    public function getOrderById(int $id)
    {
        return Order::query()
            ->findOrFail($id);
    }
    public function getCartByOrder($order)
    {
        $cart = Cart::query()
            ->where('user_id', $this->user->id)
            ->findOrFail($order->cart_id);
        $status = Status::query()
            ->where('status', 'pending')
            ->firstOrFail();
        $cartStatus = CartStatus::query()
            ->where('cart_id', $cart->id)
            ->latest()
            ->first();
        if ($cartStatus->status_id == $status->id) {
            return $cart;
        } else {
            throw new Exception('You can not change the order', 403);
        }
    }
    public function deleteAllOrders()
    {
        $cart = Cart::query()
            ->where('status', "pending")
            ->with(['orders'])
            ->where('user_id', $this->user?->id)
            ->latest()
            ->first();
        $orders = $cart->orders;
        foreach ($orders as $order) {
            $order->delete();
        }
        $statuses = $cart->statuses;
        foreach ($statuses as $status) {
            $status->delete();
        }
        return $cart->delete();
    }
    public function getCurrentCart(?array $with = ["orders.products"])
    {
        return Cart::query()
            ->with($with)
            ->where("user_id", $this->user->id)
            ->where("status", "pending")
            ->first();
    }
    public function setProductId(int $productId)
    {
        $this->productId = $productId;
        return $this;
    }
    public function setAmount(int $amount)
    {
        $this->amount = $amount;
        return $this;
    }
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
    public function setItmes(array $items)
    {
        $this->items = $items;
        return $this;
    }
    public function setShippingCost(int $shippingCost)
    {
        $this->shippingCost = $shippingCost;
        return $this;
    }
}
