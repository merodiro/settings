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
    protected $signature = 'settings:cache';

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
        $this->comment('Caching all global settings');
        $settings = Settings::all();

        foreach ($settings as $key => $value) {
            $cache_key = config('settings.cache_prefix') . $key . '_global';
            $duration = config('settings.cache_duration');

            Cache::put($cache_key, $value, $duration);
        }

        $this->info('Cached ' . count($settings) . ' settings');
    }
}
