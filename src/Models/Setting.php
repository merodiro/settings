<?php

namespace Merodiro\Settings\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'owner_id'];


    public function getCacheKeyAttribute()
    {
        $suffix = $this->owner_id ?? 'global';
        return config('settings.cache_prefix') . $this->key . '_' . $suffix;
    }
}
