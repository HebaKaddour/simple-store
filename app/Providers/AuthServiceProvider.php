<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Policies\UserPolicy;
use App\Policies\OrderPolicy;
use App\Policies\OwnerPolicy;
use App\Policies\ProductPolicy;
use App\Policies\CategoryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Product::class => ProductPolicy::class,
        Order::class => OrderPolicy::class,
        User::class => UserPolicy::class,
        User::class => OwnerPolicy::class,
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
