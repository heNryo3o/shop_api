<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Permission;
use App\Models\Push;
use App\Models\Role;
use App\Models\Upload;
use App\Models\User;
use App\Observers\AdminObserver;
use App\Observers\CategoryObserver;
use App\Observers\PermissionObserver;
use App\Observers\PushObserver;
use App\Observers\RoleObserver;
use App\Observers\UploadObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

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
        Admin::observe(AdminObserver::class);
        Permission::observe(PermissionObserver::class);
        Role::observe(RoleObserver::class);
        Push::observe(PushObserver::class);
        User::observe(UserObserver::class);
        Category::observe(CategoryObserver::class);
        Category::observe(CategoryObserver::class);
        Upload::observe(UploadObserver::class);
    }
}
