<?php

namespace Merodiro\Settings\Facades;

use Illuminate\Support\Facades\Facade;
use Merodiro\Settings\SettingsManger;

class Settings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SettingsManger::class;
    }
}
