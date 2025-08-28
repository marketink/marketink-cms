<?php

namespace App\Http\Controllers\Site;

use App\Models\Comment;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Content as ContentService;
use App\Models\Content as ContentModel;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sliders = $this->contentService->type("slider")->index()->publish()->get()->toArray();
        $banners = $this->contentService->type("banner")->index()->publish()->get()->toArray();
        $introduces = $this->contentService->type("introduce")->index()->publish()->get()->toArray();
        $SEOData = new SEOData(
            siteSetting()['siteName'],
            trans("message.parde_e_shop_seo") . " | " . trans("message.parde_e_shop"),
            siteSetting()['siteName'],
            asset('/logo.webp'),
            url()->current()
        );
        return view('site.index', compact(
            'sliders',
            'banners',
            'introduces',
            'SEOData'
        ));
    }

    public function products($category = null)
    {
        $category = $category ? $this->contentService->find($category) : null;
        $SEOData = new SEOData(
            trans("message.products"),
            trans("message.parde_e_shop_seo") . " | " . trans("message.products")
        );
        return view('site.products', compact(
            'category',
            'SEOData'
        ));
    }

    public function posts($category = null)
    {
        $category = $category ? $this->contentService->find($category) : null;
        $SEOData = new SEOData(
            trans("message.posts"),
            trans("message.parde_e_shop_seo") . " | " . trans("message.posts")
        );
        $posts = posts();
        return view('site.posts', compact(
            'category',
            'posts',
            'SEOData'
        ));
    }

    public function post($id)
    {
        $post = $this->contentService->type('blog')->index()->findOrFail($id);
        $comments = Comment::where('content_id', $id)->orderby('id', 'desc')->paginate();
        $SEOData = new SEOData(
            trans("message.posts"),
            trans("message.parde_e_shop_seo") . " | " . trans("message.posts")
        );
        return view('site.post', compact(
            'post',
            'comments',
            'SEOData'
        ));
    }

    public function postComment($id, Request $request)
    {
        $post = $this->contentService->type('blog')->index()->findOrFail($id);
        $request->validate([
            'comment' => [
                'required',
                'string', 
                function ($attribute, $value, $fail) {
                    $wordCount = str_word_count(strip_tags($value));
                    if ($wordCount > 200) {
                        $fail('تعداد کلمات ' . $attribute . ' نباید بیشتر از ۲۰۰ باشد.');
                    }
                },
            ]
        ]);
        Comment::create([
            'content_type' => ContentModel::class,
            'content_id' => $post->id,
            'comment' => $request->comment,
            'user_id' => auth()->user()->id,
        ]);
        flash('ارسال نظر شما با موفقیت ثبت شد');
        return redirect()->back();
    }

    public function product($id)
    {
        $product = $this->contentService->type('product')->find($id);
        $SEOData = new SEOData(
            trans("message.product") . " " . $product["info"]["title"] ?? "",
            trans("message.parde_e_shop_seo") . " | " . trans("message.products")
        );
        return view('site.product', compact(
            'product',
            'SEOData'
        ));
    }

}
