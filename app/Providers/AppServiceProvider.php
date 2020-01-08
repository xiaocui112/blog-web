<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\Category;
use Laravel\Passport\Passport;
use App\Observers\ReplyObserver;
use App\Observers\TopicObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\Resource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Topic::observe(TopicObserver::class);
        Reply::observe(ReplyObserver::class);
        View::share('categorys', Category::all());
        Resource::withoutWrapping();
        // Passport::routes();
        // Passport::tokensExpireIn(now()->addDays(5));
        // Passport::refreshTokensExpireIn(now()->addDays(5));
    }
}
