<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Services\Content;
use Illuminate\Support\Facades\Cache;

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
                $view->with($type['type'], Cache::rememberForever($key, function () use ($type) {
                    return app(Content::class)->type($type['type'])->index()->publish()->get()->toArray();
                }));
            }
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
