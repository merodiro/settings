<?php

namespace Merodiro\Settings\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Merodiro\Settings\Facades\Settings;

class SettingsClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:clear {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear settings cache';

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
        $this->comment('Clearing settings cache.');
        $settings = Settings::all();

        foreach ($settings as $key => $value) {
            $cache_key = Settings::cacheKey($key);

            Cache::forget($cache_key);
        }

        $model = $this->option('model');

        if (isset($model)) {
            $users = (new $model)->all();
            foreach ($users as $user) {
                $settings = $user->allSettings();
                foreach ($settings as $key => $value) {
                    $cache_key = $user->settingsCacheKey($key);

                    Cache::forget($cache_key);
                }
            }
        }

        $this->info('Cleared ' . count($settings) . ' settings cache.');
    }
}
