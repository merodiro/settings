<?php

namespace Merodiro\Settings;

use Illuminate\Support\Facades\Cache;
use Merodiro\Settings\Models\Setting;

class SettingsManger
{
    public function all()
    {
        return Setting::whereNull('owner_id')->pluck('value', 'key');
    }

    public function set($key, $value)
    {
        $cache_key = config('settings.cache_prefix') . $key . '_global';
        $duration = config('settings.cache_duration');

        Setting::updateOrCreate(['key' => $key, 'owner_id' => null], ['value' => $value]);
        Cache::put($cache_key, $value, $duration);
    }

    public function get($key, $default = null)
    {
        $cache_key = config('settings.cache_prefix') . $key . '_global';

        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        }

        $value = Setting::where('key', $key)->whereNull('owner_id')->pluck('value')->first();

        return $value ? $value : $default;
    }

    public function forget($key)
    {
        Setting::where('key', $key)->whereNull('owner_id')->first()->delete();
    }

    public function flush()
    {
        Setting::whereNull('owner_id')->each(function ($item) {
            $item->delete();
        });
    }
}
