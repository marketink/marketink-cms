<?php

namespace App\Http\Controllers;

use App\Services\Content as ContentService;
use Illuminate\Http\Request;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class SettingController extends Controller
{
    protected ContentService $contentService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }
    public function aboutUs()
    {
        $aboutUs = $this->contentService->type('about-us')->index()->publish()->get();
        return view("settings.about_us",[
            "aboutUs" => $aboutUs,
            "SEOData" => new SEOData(
                title: trans("message.about_us"),
                description: trans("message.parde_e_shop_seo")." | ". trans("message.about_us")
            )
        ]);
    }

    public function faq()
    {
        $faq = $this->contentService->type('faq')->index()->publish()->get();
        return view("settings.faq",[
            "faq" => $faq,
            "SEOData" => new SEOData(
                title: trans("message.faq"),
                description: trans("message.parde_e_shop_seo")." | ". trans("message.faq")
            )
        ]);
    }
}
