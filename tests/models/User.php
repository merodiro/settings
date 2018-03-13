<?php

use Illuminate\Foundation\Auth\User as Authenticatable;
use Merodiro\Settings\HasSettings;

class User extends Authenticatable
{
    use HasSettings;
}
