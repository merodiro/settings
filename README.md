# settings

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

laravel easy `key => value` global/user settings

## Install

Via Composer

``` bash
$ composer require merodiro/settings
```

publish config through
Optional: only if you want to edit cache configurations

```bash
$ php artisan vendor:publish --provider=Merodiro\Settings\SettingsServiceProvider
```
## Setup a Model
```php
use Merodiro\Settings\HasSettings;

class User extends Model
{
    use HasSettings;
    ...
}
```

## Usage

### Set settings
creates a record if the key doesn't exist or update it if the key exists

in addition to updating the cache

```php
// Global Settings
Settings::set('key', 'value');
Settings::set('key', 'another value');

// User Settings
$user->setSettings('key', 'value');
$user->setSettings('key', 'another value');
```


### Get value from settings
Returns its value if it exists or the second parameter if it doesn't exist

```php
// Global Settings
$name = Settings::get('site-name');
$value = Settings::get('key', 'default');

// User Settings
$user->getSettings('site-name');
$user->getSettings('key', 'value');
```

### Delete key from settings
Remove the setting with the given key
in addition to removing it from the cache

```php
// Global Settings
Settings::forget('key');

// User Settings
$user->forgetSettings('key');
```

### Delete all settings
Delete all the settings
in addition to removing them from the cache

```php
// Global Settings
Settings::flush();

// User Settings
$user->flushSettings();
```

### Get all settings
Returns all settings stored in key => value array

```php
// Global Settings
$settings = Settings::all();

// User Settings
$settings = $user->allSettings();
```

## Artisan Commands

### Cache all settings
Caches all settings for the duration that has been set in settings.php config file

*you can set the duration to a high number or schedule the command to run often to get the best value of it*

```bash
# Global settings only
php artisan settings:cache

# Global and User Settings
php artisan settings:cache --model=App/User
```

### Clear cache for all settings

```bash
# Global settings only
$ php artisan settings:clear

# Global and User Settings
$ php artisan settings:clear --model=App/User
```

## Blade Directives

### Get value from blade template

```php
<h1>@settings('site-name')</h1>
<h1>@settings('site-name', 'default name')</h1>
```


## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security-related issues, please email merodiro@gmail.com instead of using the issue tracker.

## Credits

- [Amr A. Mohammed][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/merodiro/settings.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/merodiro/settings/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/merodiro/settings.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/merodiro/settings.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/merodiro/settings.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/merodiro/settings
[link-travis]: https://travis-ci.org/merodiro/settings
[link-scrutinizer]: https://scrutinizer-ci.com/g/merodiro/settings/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/merodiro/settings
[link-downloads]: https://packagist.org/packages/merodiro/settings
[link-author]: https://github.com/merodiro
[link-contributors]: ../../contributors
