<?php

namespace KevinBHarris\EbayConnector\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use KevinBHarris\EbayConnector\Console\Commands\SyncProductsCommand;
use KevinBHarris\EbayConnector\Console\Commands\SyncOrdersCommand;
use KevinBHarris\EbayConnector\Services\EbayApiClient;
use KevinBHarris\EbayConnector\Services\ProductSyncService;
use KevinBHarris\EbayConnector\Services\OrderSyncService;

class EbayConnectorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../publishable/config/ebayconnector.php',
            'ebayconnector'
        );

        // Register services
        $this->app->singleton(EbayApiClient::class, function ($app) {
            return new EbayApiClient(
                config('ebayconnector.api_key'),
                config('ebayconnector.api_secret'),
                config('ebayconnector.environment')
            );
        });

        $this->app->singleton(ProductSyncService::class);
        $this->app->singleton(OrderSyncService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'ebayconnector');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'ebayconnector');
        
        $this->registerRoutes();
        $this->registerCommands();
        $this->registerPublishables();
        $this->registerEventListeners();
        $this->registerMenuItems();
        $this->registerACL();
    }

    /**
     * Register routes.
     */
    protected function registerRoutes(): void
    {
        Route::group([
            'middleware' => ['web', 'admin'],
            'prefix' => config('app.admin_url') . '/ebayconnector',
            'namespace' => 'KevinBHarris\EbayConnector\Http\Controllers\Admin',
        ], function () {
            require __DIR__ . '/../Http/routes.php';
        });
    }

    /**
     * Register console commands.
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SyncProductsCommand::class,
                SyncOrdersCommand::class,
            ]);
        }
    }

    /**
     * Register publishable resources.
     */
    protected function registerPublishables(): void
    {
        $this->publishes([
            __DIR__ . '/../../publishable/config/ebayconnector.php' => config_path('ebayconnector.php'),
        ], 'ebayconnector-config');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('vendor/ebayconnector'),
        ], 'ebayconnector-assets');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/ebayconnector'),
        ], 'ebayconnector-views');
    }

    /**
     * Register event listeners.
     */
    protected function registerEventListeners(): void
    {
        // Event listeners for automatic sync will be registered here
        // For example: product created, updated, deleted events
    }

    /**
     * Register menu items for admin sidebar.
     */
    protected function registerMenuItems(): void
    {
        $menuItems = require __DIR__ . '/../../publishable/config/menu.php';

        foreach ($menuItems as $menuItem) {
            $this->app['core']->addMenuItems($menuItem);
        }
    }

    /**
     * Register ACL permissions.
     */
    protected function registerACL(): void
    {
        $aclItems = require __DIR__ . '/../../publishable/config/acl.php';

        foreach ($aclItems as $aclItem) {
            $this->app['core']->addACL($aclItem);
        }
    }
}
