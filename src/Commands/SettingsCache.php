<?php

namespace Merodiro\Settings\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Merodiro\Settings\Facades\Settings;

class SettingsCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:cache {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache all settings';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Caching all settings');
        $duration = config('settings.cache_duration');

        Settings::all()->each(function ($value, $key) use ($duration) {
            $cache_key = Settings::cacheKey($key);

            Cache::put($cache_key, $value, $duration);
        });

        $model = $this->option('model');

        if (isset($model)) {
            (new $model)->all()->each(function ($user) use ($duration) {
                $user->allSettings()->each(function ($value, $key) use ($user, $duration) {
                    $cache_key = $user->settingsCacheKey($key);

                    Cache::put($cache_key, $value, $duration);
                });
            });
        }

        $this->info('Cached all settings');
    }
}
