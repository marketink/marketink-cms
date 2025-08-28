<?php

function currencies(): array
{
    return [
        [
            "currency" => "TMN",
            "name" => "تومان"
        ]
    ];
}

function langs(): array
{
    return [
        [
            "lang" => "fa",
            "country" => [
                "code" => "ir",
                "name" => "iran"
            ],
            "theme" => "rtl"
        ]
    ];
}

function types(): array
{
    return [
        [
            "type" => "category",
            "price" => false,
            "discount" => false,
            "stock" => false,
            "media" => true,
            "label" => [
                "title" => "string",
                "body" => "text",
                "blog" => "link"
            ],
            "name" => trans("message.category"),
            "files" => ["logo"],
            "menu_icon" => "category",
            "relations" => [
                [
                    "to" => "category",
                    "parent" => 1,
                    "child" => -1
                ]
            ]
        ],
        [
            "type" => "blog",
            "price" => false,
            "discount" => false,
            "stock" => false,
            "media" => true,
            "label" => [
                "title" => "string",
                "body" => "text",
                "embed" => "text",
                "label" => "string",
                "read" => "string",
            ],
            "name" => trans("message.blog"),
            "files" => ["banner"],
            "menu_icon" => "article",
            "relations" => []
        ],
        [
            "type" => "product",
            "price" => true,
            "discount" => false,
            "stock" => true,
            "media" => true,
            "label" => [
                "title" => "string",
                "label" => "string",
                "body" => "text",
            ],
            "name" => trans("message.product"),
            "files" => ["banner", "experience", "vector"],
            "menu_icon" => "inventory_2",
            "relations" => [
                [
                    "to" => "category",
                    "parent" => 1,
                    "child" => 0
                ]
            ]
        ],
        [
            "type" => "introduce",
            "price" => false,
            "discount" => false,
            "stock" => false,
            "media" => true,
            "label" => [
                "title" => "string",
                "body" => "text",
            ],
            "name" => trans("message.introduce"),
            "files" => ["icon"],
            "menu_icon" => "info",
            "relations" => [
                [
                    "to" => "category",
                    "parent" => 1,
                    "child" => 0
                ]
            ]
        ],
        [
            "type" => "banner",
            "price" => false,
            "discount" => false,
            "stock" => false,
            "media" => true,
            "label" => [
                "title" => "string",
                "link" => "link",
                "label" => "string",
                "subtitle" => "string",
            ],
            "name" => trans("message.banner"),
            "files" => ["banner"],
            "menu_icon" => "campaign",
            "relations" => []
        ],
        [
            "type" => "slider",
            "price" => false,
            "discount" => false,
            "stock" => false,
            "media" => true,
            "label" => [
                "title" => "string",
                "link" => "link",
                "body" => "text",
                "label" => "string",
                "subtitle" => "string",
            ],
            "name" => trans("message.slider"),
            "files" => ["banner"],
            "menu_icon" => "chevron_right",
            "relations" => []
        ],
        [
            "type" => "social",
            "price" => false,
            "discount" => false,
            "stock" => false,
            "media" => false,
            "label" => [
                "icon" => "string",
                "link" => "link",
            ],
            "files" => [],
            "name" => trans("message.social"),
            "menu_icon" => "ads_click",
            "relations" => []
        ],
        [
            "type" => "about-us",
            "price" => false,
            "discount" => false,
            "stock" => false,
            "media" => true,
            "label" => [
                "title" => "string",
                "body" => "text",
            ],
            "name" => trans("message.about_us"),
            "files" => ["banner"],
            "menu_icon" => "article",
            "relations" => []
        ],
        [
            "type" => "faq",
            "price" => false,
            "discount" => false,
            "stock" => false,
            "media" => false,
            "label" => [
                "question" => "string",
                "answer" => "text",
            ],
            "name" => trans("message.faq"),
            "files" => [],
            "menu_icon" => "article",
            "relations" => []
        ]
    ];
}

function roles()
{
    return [
        "customer",
        "admin"
    ];
}

function defaultRole()
{
    return roles()[0];
}

function defaultLang()
{
    return langs()[0]['lang'];
}

function defaultCurrency()
{
    return currencies()[0]['currency'];
}

function statuses()
{
    return [
        [
            "type" => "category",
            "status" => [
                "publish",
                "draft"
            ]
        ],
        [
            "type" => "blog",
            "status" => [
                "publish",
                "draft"
            ]
        ],
        [
            "type" => "product",
            "status" => [
                "publish",
                "draft"
            ]
        ],
        [
            "type" => "introduce",
            "status" => [
                "publish",
                "draft"
            ]
        ],
        [
            "type" => "banner",
            "status" => [
                "publish",
                "draft"
            ]
        ],
        [
            "type" => "slider",
            "status" => [
                "publish",
                "draft"
            ]
        ],
        [
            "type" => "social",
            "status" => [
                "publish",
                "draft"
            ]
        ],
        [
            "type" => "cart",
            "status" => [
                "pending",
                "paid",
                "prepare",
                "sent",
            ]
        ],
        [
            "type" => "about-us",
            "status" => [
                "publish",
                "draft",
            ]
        ],
        [
            "type" => "faq",
            "status" => [
                "publish",
                "draft",
            ]
        ],
        [
            "type" => "terms",
            "status" => [
                "publish",
                "draft",
            ]
        ]
    ];
}

function siteSetting()
{
    return collect([
        "usernameType" => "mobile",
        "usernameValidate" => 'regex:/^(\+\d{1,3}?\d{11}$)|^(09\d{1}?\d{8}$)/i',
        'dateFunction' => function ($time = null) {
            return verta($time);
        },
        "siteName" => env('APP_NAME'),
        'siteLnaguage' => 'fa',
        'storage_driver' => 'ftp',
        'afterContentUpdate' => function ($item) {
            Cache::forget("$item->type-in-site");
        },
        'afterContentStore' => function ($item) {
            Cache::forget("$item->type-in-site");
        },
        'afterContentDelete' => function ($item) {
            Cache::forget("$item->type-in-site");
        },
        'assets' => [
            'css' => [
                'main' => "1.0.4" . time(),
            ],
            'js' => [
                'main' => "1.1.0" . time()
            ],
        ]
    ]);
}
function checkActiveMenu($url, $default = 'text-dark', $active = "")
{
    if (request()->url() === $url) {
        return $active;
    }
    return $default;
}

function getLastUrlTitle()
{
    $url = request()->url();
    $url = explode("/", $url);
    $url = $url[count($url) - 1];
    return trans("message.$url");
}


function get($data, $path)
{
    $segments = explode('.', $path);

    foreach ($segments as $segment) {
        if (is_array($data) && array_key_exists($segment, $data)) {
            $data = $data[$segment];
        } elseif (is_object($data) && isset($data->$segment)) {
            $data = $data->$segment;
        } else {
            return null;
        }
    }

    return is_string($data) ? removeBOM($data) : $data;
}

function removeBOM($str)
{
    return preg_replace('/^\xEF\xBB\xBF/u', '', $str);
}

function categories()
{
    return Cache::rememberForever("category-in-site", function () {
        return app(App\Services\Content::class)->type("category")->index()->parent()->publish()->get()->toArray();
    });
}

function socials()
{
    return Cache::rememberForever("social-in-site", function () {
        return app(App\Services\Content::class)->type("social")->index()->publish()->get()->toArray();
    });
}

function products()
{
    return Cache::rememberForever("product-in-site", function () {
        return app(App\Services\Content::class)->type("product")->index()->publish()->with('parents')->get()->toArray();
    });
}

function posts()
{
    return app(App\Services\Content::class)->type("blog")->index()->publish()->with('parents')->paginate();
}

function collectProducts($products, $relations = [])
{
    $request = request();
    $data = collect($products);
    try {
        switch ($request->sort) {
            case '1':
                $data = $data->sortByDesc('id');
                break;
            case '2':
                $data = $data->sortByDesc('info.final_price');
                break;
            case '3':
                $data = $data->sortBy('info.final_price');
                break;
            default:
                $data = $data->sortByDesc('id');
        }
    } catch (\Exception $e) {

    }
    if ($request->search)
        $data = $data->filter(function ($item) use ($request) {
            return Str::contains($item['info']['title'], $request->search);
        });
    if (count($relations) > 0)
        $data = $data->filter(function ($item) use ($relations) {
            return collect($item['parents'])->pluck('id')->intersect($relations)->isNotEmpty();
        });


    return $data;
}

function productSortLists()
{
    return [
        [
            "title" => "جدیدترین",
            "key" => 1
        ],
        [
            "title" => "گرانترین",
            "key" => 2
        ],
        [
            "title" => "ارزان ترین",
            "key" => 3
        ]
    ];
}
function getProvinces()
{
    $service = new \App\Services\Location\StateService();
    return $service->getAllProvinces();
}
function getCities(int $id)
{
    $service = new \App\Services\Location\StateService();
    return $service->getCitiesByProvinceId($id);
}
function toJalali($time)
{
    return verta($time)->format("l d S F");
}


function sides()
{
    return [
        [
            "name" => trans("message.side_v1"),
            "from" => "100",
            "value" => 1,
            "image" => asset("assets/platform/images/1.png")
        ],
        [
            "name" => trans("message.side_v2"),
            "from" => "100",
            "value" => 2,
            "image" => asset("assets/platform/images/2.png")
        ],
        [
            "name" => trans("message.side_v3"),
            "from" => "0",
            "value" => 3,
            "image" => asset("assets/platform/images/3.png")
        ],
        [
            "name" => trans("message.side_v4"),
            "from" => "0",
            "value" => 4,
            "image" => asset("assets/platform/images/4.png")
        ],
        [
            "name" => trans("message.side_v5"),
            "from" => "300",
            "value" => 5,
            "image" => asset("assets/platform/images/5.png")
        ]
    ];
}

function getSetting()
{
    return \App\Models\Setting::first();
}

function orderDetail($key, $value)
{
    $response = "";
    switch ($key) {
        case 'rod':
            if ($value == 1)
                $response = "دستی";
            if ($value == 2)
                $response = "اتوماتیک";
            break;
        case 'from':
            $response = trans("message.side_v$value");
            break;
        case 'tool':
            $response = "میله ابزار انتخابی در سفارش";
            if ($value == 0)
                $response = "میله ابزار ندارم";
            break;
        case 'dookht':
            $response = "میله ابزار انتخابی در سفارش";
            if ($value == 1)
                $response = "پانچ (پنل آماده)";
            if ($value == 2)
                $response = "مینیمال (ارتفاع سفارشی)";
            if ($value == 3)
                $response = "پانچ (پنل سفارشی)";
            break;
        case 'base_type':
            $response = "";
            if ($value == 1)
                $response = "دیواری";
            if ($value == 2)
                $response = "سقفی";
            break;
        case 'porchin_kamchin':
            $response = "";
            if($value == "kamchin")
                $response = "کم چین";
            else
                $response = "پر چین";
            break;
        default:
            $response = $value;
    }
    ;
    return $response;
}