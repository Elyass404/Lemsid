<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\TagRepository;
use Illuminate\Support\Facades\Route;
use App\Repositories\CourseRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\RateLimiter;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Spatie\Permission\Middlewares\RoleMiddleware;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
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

        Route::middlewareGroup('api', [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            EnsureFrontendRequestsAreStateful::class,  // This is for Sanctum
         ]);
    }
}
