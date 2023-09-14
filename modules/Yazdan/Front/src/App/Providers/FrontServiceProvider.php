<?php

namespace Yazdan\Front\App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Yazdan\Category\Repositories\CategoryRepository;
use Yazdan\Course\Repositories\CourseRepository;

class FrontServiceProvider extends ServiceProvider
{
    public function register()
    {
        Route::middleware('web')
                ->group(__DIR__ . '/../../Routes/front_routes.php');

        $this->loadViewsFrom(__DIR__ . '/../../Resources/views/', 'Front');

        view()->composer('Front::layouts.sections.header', function ($view) {
            $categories = CategoryRepository::tree();
            $view->with(compact('categories'));
        });

        view()->composer('Front::layouts.course.latestCourses', function ($view) {
            $latestCourses = CourseRepository::latestCourse();
            $view->with(compact('latestCourses'));
        });
    }
}
