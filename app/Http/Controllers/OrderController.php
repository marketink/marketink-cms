<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Requests\ShopSingleRequest;
use App\Services\ShopService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class OrderController extends Controller
{
    public function create(OrderRequest $request)
    {
        try {
            if (!auth()->user()->username_verified_at) {
                throw new Exception("لطفا شماره موبایل خود را تایید کنید");
            }
            return ShopService::make()
                ->setUser(auth()->user())
                ->multiple($request->validated());
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 403);
        }
    }
    public function index()
    {
        $carts = ShopService::make()
            ->setUser(auth()->user())
            ->get();
        return view("shop.index", [
            "carts" => $carts,
            "SEOData" => new SEOData(
                title: trans("message.orders"),
                description: trans("message.parde_e_shop_seo") . " | " . trans("message.orders") . " | " . trans("message.cart")
            )
        ]);

    }
    public function show(int $id)
    {
        $cart = ShopService::make()
            ->setUser(auth()->user())
            ->show($id);
        return view("shop.show", [
            "cart" => $cart,
            "SEOData" => new SEOData(
                title: trans("message.order"),
                description: trans("message.parde_e_shop_seo") . " | " . trans("message.orders") . " | " . trans("message.cart")
            )
        ]);
    }

    public function deleteAllOrders(Request $request)
    {
        ShopService::make()
            ->setUser(auth()->user())
            ->deleteAllOrders();
        return redirect()->to(route("current.cart"));
    }

    public function delete(int $orderId, Request $request)
    {
        $order = ShopService::make()
            ->setUser($this->user())
            ->delete($orderId);
        flash('با موفقیت حذف شد.');
        return redirect()
            ->back();
    }
    public function updateField(int $id, $key, Request $request)
    {
        $cart = ShopService::make()
            ->setUser(auth()->user())
            ->updateField($id, $key, $request->input($key));
        return redirect()->to(route("current.cart"));
    }
    public function getCurrentCart()
    {
        $cart = ShopService::make()
            ->setUser(auth()->user())
            ->getCurrentCart();
        return view("shop.show", [
            "cart" => $cart,
            "SEOData" => new SEOData(
                title: trans("message.cart"),
                description: trans("message.parde_e_shop_seo") . " | " . trans("message.orders") . " | " . trans("message.cart")
            )
        ]);
    }

    public function postCurrentCart(Request $request)
    {
        $request->validate([
            'address_id' => [
                'required',
                Rule::exists('addresses', 'id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ]
        ]);

        $cart = ShopService::make()
            ->setUser(auth()->user())
            ->getCurrentCart([]);
        $cart->address_id = $request->address_id;
        $cart->save();

        flash('آدس با موفقیت ثبت شد');
        return redirect()->back();
    }

    public function storeSingle(ShopSingleRequest $request)
    {
        try {
            $cart = ShopService::make()
                ->setUser(auth()->user())
                ->setAmount($request->quantity)
                ->setProductId($request->product_id)
                ->createSingle();

            return redirect()
                ->to(route("current.cart"));
        }
        catch(Exception $e){
            return redirect()->back()->withErrors(["msg" => $e->getMessage()]);

        }
    }
}
