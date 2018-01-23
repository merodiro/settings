<?php

namespace Merodiro\Settings\Observers;

use Merodiro\Settings\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingObserver
{
<<<<<<< HEAD

=======
>>>>>>> 742e658f3d6445afb3b5e5f5e9bf1e3f44b5e7bb
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
