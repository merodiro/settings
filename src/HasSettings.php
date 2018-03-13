<?php

namespace Merodiro\Settings;

use Illuminate\Support\Facades\Cache;
use Merodiro\Settings\Models\Setting;

trait HasSettings
{
    public function allSettings()
    {
        return Setting::where('owner_id', $this->getKey())->pluck('value', 'key');
    }

    public function setSettings($key, $value)
    {
        Setting::updateOrCreate(['key' => $key, 'owner_id' => $this->getKey()], ['value' => $value,]);
    }

    public function getSettings($key, $default = null)
    {
        $cache_key = config('settings.cache_prefix') . $key . '-' . $this->getKey();
        $duration = config('settings.cache_duration');

        $value = Cache::remember($cache_key, $duration, function () use ($key) {
            return Setting::where('key', $key)->where('owner_id', $this->getKey())->pluck('value')->first();
        });

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
