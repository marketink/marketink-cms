<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Services\User as UserService;
use App\Services\Content as ContentService;
use App\Services\Cart as CartService;

class DashboardController extends Controller
{

    protected UserService $userService;
    protected ContentService $contentService;
    protected CartService $cartService;
    public function __construct(UserService $userService, ContentService $contentService, CartService $cartService)
    {
        $this->userService = $userService;
        $this->contentService = $contentService;
        $this->cartService = $cartService;
    }
    public function home(Request $request)
    {
        $reports = collect([
            [
                "chart_data" => $this->userService->monthlyCount(),
                "chart_label" => trans("message.customer_chart"),
                "chart_info" => trans("message.latest_registrations_performance"),
                "count_data" => $this->userService->totalCount(),
                "count_label" => trans("message.customers"),
                "count_info" => trans("message.person"),
                "month" => 6,
            ],
            [
                "chart_data" => $this->cartService->monthlyCount(6, [
                    [
                        'status',
                        '<>',
                        'pending'
                    ]
                ]),
                "chart_label" => 'نمودار فروش',
                "chart_info" => 'نمودار فروش اخیر',
                "count_data" => $this->cartService->totalCount([
                    [
                        'status',
                        '<>',
                        'pending'
                    ]
                ]),
                "count_label" => 'نمودار 6 ماه اخیر',
                "count_info" => 'عدد',
                "month" => 6,
            ],
        ]);

        return view('admin.dashboard', compact('reports'));
    }

    public function deleteRelation(Request $request)
    {
        $this->contentService->deleteRelation($request->parent_id, $request->child_id);
        return response()->json(true);
    }

    public function contents(Request $request, $type)
    {
        $types = collect(types())->where('type', $type);
        if ($types->count() == 0)
            abort(404);
        return view('admin.contents', [
            'types' => $types,
            'type' => $types->first()
        ]);
    }

    public function users(Request $request)
    {
        return view('admin.users');
    }

    public function carts(Request $request)
    {
        return view('admin.carts');
    }

    public function setting()
    {
        $setting = Setting::first();
        return view('admin.setting', [
            'setting' => $setting
        ]);
    }

    public function postSetting(Request $request)
    {
        $harir_ids = $request->harir_ids;
        $height_conf = $request->height_conf;
        $kenareh_ids = $request->kenareh_ids;
        $curtain_tools = $request->curtain_tools;
        $shipping_cost = $request->shipping_cost;
        $shipping_cost_with_rod = $request->shipping_cost_with_rod;
        $app_color = $request->app_color;
        $minimal_conf = $request->minimal_conf;
        $tel = $request->tel;
        Setting::updateOrCreate([], [
            'app_color' => $app_color,
            'option' => json_encode([
                'harir_ids' => $harir_ids,
                'height_conf' => $height_conf,
                'kenareh_ids' => $kenareh_ids,
                'curtain_tools' => $curtain_tools,
                'shipping_cost' => $shipping_cost,
                'shipping_cost_with_rod' => $shipping_cost_with_rod,
                'minimal_conf' => $minimal_conf,
                'tel' => $tel,
            ])
        ]);
        return response()->json([
            "message" => "تنظیمات با موفقیت ثبت شد"
        ]);
    }
}
