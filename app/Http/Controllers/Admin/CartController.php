<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\SendSMS;
use App\Models\Cart;
use App\Models\Status;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class CartController extends Controller
{
  public const UPDATE_CART_STATUS_PATTERN = "4ygrvxvlmg8r8k2";
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $type = $request->type;
    $status = $request->status;
    $carts = Cart::query()->with('user', 'orders.products')->when($status, function ($query) use ($status) {
      $query->where('status', $status);
    })->when($type, function ($query) use ($type) {
      $query->where('type', $type);
    });
    return DataTables::of($carts)->make(true);
  }

  /**
   * Show the specified resource in storage.
   */
  public function show(Request $request, Cart $cart)
  {
    $statuses = collect(collect(statuses())->where('type', 'cart')->first()['status'])->filter(function ($item) use ($cart) {
      return !in_array($item, collect($cart->statuses ?? [])->map(function ($item) {
        return $item->status;
      })->toArray());
    });
    return view('admin.cart', [
      'cart' => $cart,
      'statuses' => $statuses
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Cart $cart)
  {
    $statuses = collect(collect(statuses())->where('type', 'cart')->first()['status'])->filter(function ($item) use ($cart) {
      return !in_array($item, collect($cart->statuses ?? [])->map(function ($item) {
        return $item->status;
      })->toArray());
    });
    $request->validate([
      "status" => "required|in:" . join(",", $statuses->toArray())
    ]);

    DB::transaction(function () use ($cart, $request) {
      $cart->status = $request->status;
      $cart->tracking_code = $request->tracking_code;
      $cart->save();
      $user = User::query()
        ->findOrFail($cart->user_id);
      $status = new Status();
      $status->content_type = Cart::class;
      $status->content_id = $cart->id;
      $status->user_id = auth()->user()->id;
      $status->status = $request->status;
      $message = [
        'pattern' => config("sms.update_cart_status_pattern"),
        'returnMessage' => " ارسال شد",
        'message' => [
          'name' => $user->first_name . ' ' . $user->last_name,
          'id' => $cart->id,
          'status' => trans("message." . $request->status),
        ]
      ];
      SendSMS::dispatch($user->username, $message);
      $status->save();

      $transStatus = trans("message.$request->status");
    });

    return response()->json([
      "message" => "با موفقیت ثبت شد"
    ]);

  }

}
