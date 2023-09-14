<?php

namespace Yazdan\Course\App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Yazdan\Course\App\Models\Course;
use Yazdan\Course\App\Models\Lesson;
use Yazdan\Course\App\Models\Season;
use Yazdan\Course\App\Policies\CoursePolicy;
use Yazdan\Course\App\Policies\LessonPolicy;
use Yazdan\Course\App\Policies\SeasonPolicy;
use Yazdan\RolePermissions\Repositories\PermissionRepository;

class CourseServiceProvider extends ServiceProvider
{
    public function register()
    {
        Route::middleware('web')
            ->group(__DIR__ . '/../../Routes/course_routes.php');
        Route::middleware('web')
            ->group(__DIR__ . '/../../Routes/season_routes.php');
        Route::middleware('web')
            ->group(__DIR__ . '/../../Routes/lesson_routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../../Database/migrations/');

        $this->loadViewsFrom(__DIR__ . '/../../Resources/views/course', 'Course');
        $this->loadViewsFrom(__DIR__ . '/../../Resources/views/season', 'Season');
        $this->loadViewsFrom(__DIR__ . '/../../Resources/views/lesson', 'Lesson');


        $this->loadJsonTranslationsFrom(__DIR__ . '/../../Resources/Lang/');

        Gate::policy(Course::class, CoursePolicy::class);
        Gate::policy(Season::class, SeasonPolicy::class);
        Gate::policy(Lesson::class, LessonPolicy::class);
    }

    public function boot()
    {
        // $this->app->booted(function () {
        //     config()->set('sidebar.items.courses', [
        //         'icon' => 'i-courses',
        //         'url' => route('admin.courses.index'),
        //         'title' => 'دوره ها',
        //         'permission' => [
        //             PermissionRepository::PERMISSION_MANAGE_COURSES,
        //             PermissionRepository::PERMISSION_MANAGE_OWN_COURSES
        //         ],
        //     ]);
        // });
        $this->app->booted(function () {
            config()->set('sidebarHome.items.courses', [
                'icon' => 'i-courses',
                'url' => route('admin.courses.index'),
                'title' => 'دوره ها',
                'permission' => [
                    PermissionRepository::PERMISSION_MANAGE_COURSES,
                    PermissionRepository::PERMISSION_MANAGE_OWN_COURSES
                ],
            ]);
        });
    }
}
