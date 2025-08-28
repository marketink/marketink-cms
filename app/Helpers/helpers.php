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
            "in_layout" => true,
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
            ],
            "routes" => [
                [
                    "name" => "categories",
                    "json" => false,
                    "find" => false,
                    "view" => "site.categories",
                    "seo" => [
                        "title" => "",
                        "description" => ""
                    ]
                ],
                [
                    "name" => "category",
                    "json" => false,
                    "find" => true,
                    "view" => "site.category",
                    "seo" => [
                        "title" => "",
                        "description" => ""
                    ]
                ]
            ]
        ],
        [
            "type" => "blog",
            "price" => false,
            "discount" => false,
            "stock" => false,
            "media" => true,
            "comment" => true,
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
            "relations" => [],
            "routes" => [
                [
                    "name" => "blogs",
                    "json" => false,
                    "find" => false,
                    "view" => "site.blogs",
                    "seo" => [
                        "title" => trans("message.posts"),
                        "description" => trans("message.posts")
                    ]
                ],
                [
                    "name" => "blog",
                    "json" => false,
                    "find" => true,
                    "view" => "site.blog",
                    "seo" => [
                        "title" => trans("message.posts"),
                        "description" => trans("message.posts")
                    ]
                ]
            ]
        ],
        [
            "type" => "product",
            "price" => true,
            "discount" => false,
            "stock" => true,
            "media" => true,
            "shop" => true,
            "comment" => true,
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
            ],
            "routes" => [
                [
                    "name" => "products",
                    "json" => false,
                    "find" => false,
                    "view" => "site.products",
                    "seo" => [
                        "title" => trans("message.products"),
                        "description" => trans("message.products")
                    ]
                ],
                [
                    "name" => "product",
                    "json" => false,
                    "find" => true,
                    "view" => "site.product",
                    "seo" => [
                        "title" => trans("message.product"),
                        "description" => trans("message.product")
                    ]
                ]
            ]
        ],
        [
            "type" => "introduce",
            "price" => false,
            "discount" => false,
            "stock" => false,
            "media" => true,
            "in_home" => true,
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
            "in_home" => true,
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
            "in_home" => true,
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
            "in_layout" => true,
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
            "relations" => [],
            "routes" => [
                [
                    "name" => "about-us",
                    "json" => false,
                    "find" => false,
                    "view" => "site.about-us",
                    "seo" => [
                        "title" => trans("message.about_us"),
                        "description" => trans("message.about_us"),
                    ]
                ],
            ]
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
            "relations" => [],
            "routes" => [
                [
                    "name" => "faq",
                    "json" => false,
                    "find" => false,
                    "view" => "site.faq",
                    "seo" => [
                        "title" => trans("message.faq"),
                        "description" => trans("message.faq"),
                    ]
                ],
            ]
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

function getSetting()
{
    return \App\Models\Setting::first();
}
