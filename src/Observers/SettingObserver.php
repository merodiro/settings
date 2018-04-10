<?php

namespace Merodiro\Settings\Observers;

use Illuminate\Support\Facades\Cache;
use Merodiro\Settings\Models\Setting;

class SettingObserver
{
    public function saved(Setting $setting)
    {
        $duration = config('settings.cache_duration');

        Cache::put($setting->cacheKey, $setting->value, $duration);
    }

    public function deleted(Setting $setting)
    {
        Cache::forget($setting->cacheKey);
    }
}
