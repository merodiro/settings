<?php

namespace Merodiro\Settings;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

use Merodiro\Settings\Commands\SettingsCache;
use Merodiro\Settings\Commands\SettingsClear;
use Merodiro\Settings\Observers\SettingObserver;
use Merodiro\Settings\Models\Setting;

class SettingsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/settings.php' => config_path('settings.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/config/settings.php',
            'settings'
        );

        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                SettingsCache::class,
                SettingsClear::class
            ]);
        }
        Setting::observe(SettingObserver::class);

        Blade::directive('settings', function ($expression) {
            return "<?php echo Settings::get($expression); ?>";
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SettingsManger::class, function () {
            return new SettingsManger();
        });
    }
}
