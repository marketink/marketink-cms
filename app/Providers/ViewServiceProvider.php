<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Services\Content;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;
use Illuminate\Support\Str;

class ViewServiceProvider extends ServiceProvider
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    /**
     * Register services.
     */
    public function register(): void
    {
        View::composer('*', function ($view)  {
            $types = collect(types())->where('in_layout', true);
            foreach ($types as $type) {
                $key = $type['type'] . "-in-site";
                if(isset($type['in_layout_query']) && is_array($type['in_layout_query'])){
                    $viewKey = Str::snake(Str::pluralStudly($type['type'])) . '_data';
                } else {
                    $viewKey = Str::snake(Str::pluralStudly($type['type']));
                }
                $view->with($viewKey, Cache::rememberForever($key, function () use ($type) {
                    $query = app(Content::class)->type($type['type'])->index();
                    $data = [];
                    if(isset($type['in_layout_query']) && is_array($type['in_layout_query'])){
                        foreach($type['in_layout_query'] as $in){
                            $key = $in['name'] ?? Str::snake(Str::pluralStudly($type['type']));
                            $d = $query->where($in['where'])->limit($in['limit'])->orderby($in['order']['field'], $in['order']['sort']);                    
                            $data[$key] = $d->get()->toArray();
                        }
                        return $data;
                    } else {
                        $query = $query->parent()->publish()->get()->toArray();
                        return $query;
                    }
                }));
            }
            $view->with('platformSetting', Setting::first());
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
