<?php

namespace Merodiro\Settings\Observers;

use Illuminate\Support\Facades\Cache;
use Merodiro\Settings\Models\Setting;

class SettingObserver
{
    public function updated(Setting $setting)
    {
        $suffix = $setting->owner_id ? $setting->owner_id: 'global';

        $cache_key = config('settings.cache_prefix') . $setting->key . '_' . $suffix;

        Cache::forget($cache_key);
    }

    public function deleted(Setting $setting)
    {
        $suffix = $setting->owner_id ? $setting->owner_id: 'global';

        $cache_key = config('settings.cache_prefix') . $setting->key . '_' . $suffix;

        Cache::forget($cache_key);
    }
}
