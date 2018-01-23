<?php

namespace Merodiro\Settings\Observers;

use Merodiro\Settings\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingObserver
{
    public function updated(Setting $setting)
    {
        $cache_key = config('settings.cache_prefix') . $setting->key;

        Cache::forget($cache_key);
    }

    public function deleted(Setting $setting)
    {
        $cache_key = config('settings.cache_prefix') . $setting->key;

        Cache::forget($cache_key);
    }
}
