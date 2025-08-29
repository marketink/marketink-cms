<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Content as ContentService;
use App\Models\Content as ContentModel;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Illuminate\Support\Str;

class SiteController extends Controller
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
        $types = collect(types())->where('in_home', true);
        $data = [];
        foreach ($types as $type) {
            $query = $this
            ->contentService
            ->type($type['type'])
            ->index()
            ->publish();
            if(isset($type['in_home_query']) && is_array($type['in_home_query'])){
                foreach($type['in_home_query'] as $in){
                    $k = $in['name'] ? "_" . $in['name'] : '';
                    $key = Str::snake(Str::pluralStudly($type['type'] . $k));
                    $d = $query->where($in['where'])->limit($in['limit'])->orderby($in['order']['field'], $in['order']['sort']);                    
                    $data[$key] = $d->get()->toArray();
                }
            } else {
                $query = $query->get()->toArray();
                $data[Str::snake(Str::pluralStudly($type['type']))] = $query;
            }
        }

        $data['SEOData'] = new SEOData(
            siteSetting()['siteName'],
            trans("message.parde_e_shop_seo") . " | " . trans("message.parde_e_shop"),
            siteSetting()['siteName'],
            asset('/logo.webp'),
            url()->current()
        );
        return view('site.index', $data);
    }


    public function contents($type, $path = null)
    {
        $types = collect(types())->first(function ($item) use ($type) {
            return collect($item['routes'] ?? [])
                ->pluck('name')
                ->contains($type);
        }) ?? abort(404);

        $route = collect($types['routes'])->where('name', $type)->first();
        $contents = $this->contentService->type($types['type'])->index()->publish();
        $segments = explode('/', $path);

        $data = [
            "SEOData" => [
                "title" => $route["seo"]["title"] ?? "",
                "description" => $route["seo"]["description"] ?? "",
            ]
        ];

        if (isset($route['find']) && $route['find'] == true) {
            if (count($segments) == 1) {
                $content = $contents->with('parents')->findOrFail($segments[0]);
                $data['content'] = $content;
                $data['SEOData']["title"] = $data['SEOData']["title"] . ($content["info"]["title"] ?? "");
                $data['SEOData']["description"] = $data['SEOData']["description"] . ($content["info"]["title"] ?? "");
            } else {
                abort(404);
            }
        } else {
            $contents = $contents->paginate();
            $data['contents'] = $contents;
        }

        if (isset($route["json"]) && $route["json"] == true) {
            return response()->json($data);
        }

        $data['SEOData'] = new SEOData($data['SEOData']["title"], $data['SEOData']["description"]);
        return view($route["view"], $data);
    }

    public function postComment($id, Request $request)
    {
        $types = collect(types())->where("comment", true)->pluck("type")->values();
        $post = $this->contentService->type($types)->index()->findOrFail($id);
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

}
