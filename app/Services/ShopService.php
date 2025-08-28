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

    public function create()
    {
        $setting = getSetting();

        $types = collect(types());

        $product = Content::query()->whereIn(
            "type",
            $types
                ->where('shop', true)
                ->pluck('type')
                ->values()
                ->toArray()
        )->findOrFail($this->productId);

        if ($product->stock < $this->amount) {
            throw new \Exception(trans("message.not_enough_stock"));
        }
        
        $cart = Cart::query()
            ->where("user_id", $this->user->id)
            ->where("status", "pending")
            ->first();

        if (!$cart) {
            $cart = Cart::query()->create([
                "user_id" => $this->user->id,
                "status" => "pending",
            ]);
        }

        $orders = Order::query()->where("cart_id", $cart->id)->get();

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
        if (count($orders) == 0) {
            $cart->delete();
            return true;
        }

        $carTotal = $cart->orders->sum("final_price");

        $shipping_cost = $setting->option->shipping_cost ?? 0;

        $cart->shipping_cost = $shipping_cost;
        $cart->total_price = $carTotal;
        $cart->final_price = $carTotal + $shipping_cost;
        $cart->save();
        return true;
    }


    public function updateField(int $id, $key, $value)
    {
        $cart = Cart::query()->where('user_id', $this->user->id)->findOrFail($id);
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
            $cart->update([$key => $value]);
        }
        return $cart->refresh();
    }

    public function delete(int $orderId)
    {
        $order = $this->getOrderById($orderId);
        $cart = Cart::query()->findOrFail($order->cart_id);
        $order->delete();
        if (count($cart->orders) == 0) {
            $cart->delete();
        }
        return 'deleted successfully';
    }

    public function getOrderById(int $id)
    {
        return Order::query()->findOrFail($id);
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
