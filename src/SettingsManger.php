<?php

namespace Merodiro\Settings;

use Illuminate\Support\Facades\Cache;

class SettingsManger
{
    public function all()
    {
        return Setting::pluck('value', 'key');
    }

    public function set($key, $value)
    {
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function get($key, $default = null)
    {
        $cache_key = config('settings.cache_prefix') . $key;
        $duration = config('settings.cache_duration');

        $value = Cache::remember($cache_key, $duration, function () use ($key) {
            return Setting::where('key', $key)->pluck('value')->first();
        });

        return $value ? $value : $default;
    }

    public function forget($key)
    {
        Setting::where('key', $key)->first()->delete();
    }

    public function flush()
    {
        Setting::get()->each(function ($item) {
            $item->delete();
        });
    }
}
