<?php

namespace Merodiro\Settings;

use Illuminate\Support\Facades\Cache;
use Merodiro\Settings\Models\Setting;

trait HasSettings
{
    abstract public function getKey();

    public function allSettings()
    {
        return Setting::where('owner_id', $this->getKey())->pluck('value', 'key');
    }

    public function setSettings($key, $value)
    {
        $cache_key = config('settings.cache_prefix') . $key . '_' . $this->getKey();
        $duration = config('settings.cache_duration');

        Setting::updateOrCreate(['key' => $key, 'owner_id' => $this->getKey()], ['value' => $value,]);
        Cache::put($cache_key, $value, $duration);
    }

    public function getSettings($key, $default = null)
    {
        $cache_key = config('settings.cache_prefix') . $key . '_' . $this->getKey();

        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        }

        $value = Setting::where('key', $key)->where('owner_id', $this->getKey())->pluck('value')->first();

        return $value ? $value : $default;
    }

    public function forgetSettings($key)
    {
        Setting::where('key', $key)->where('owner_id', $this->getKey())->first()->delete();
    }

    public function flushSettings()
    {
        Setting::where('owner_id', $this->getKey())->each(function ($item) {
            $item->delete();
        });
    }
}
