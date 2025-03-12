<?php

namespace App\Providers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Repositories\CourseRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use App\Repositories\Interfaces\CourseRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(60)->by($request->ip());
        });
    
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }
}
