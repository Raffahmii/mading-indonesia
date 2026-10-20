<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\University;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\PostPolicy;
use App\Policies\UniversityPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register policies
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(University::class, UniversityPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
    }
}