# settings

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

laravel easy `key => value` global settings

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
## Usage

### Set settings
creates a record if the key doesn't exist or update it if the key exists
in addition  to updating the cache

```php
Settings::set('key', 'value');
Settings::set('key', 'another value');
```

### Get value from settings
Returns its value if it exists or the second parameter if it doesn't exist
and caches settings automatically

```php
$name = Settings::get('site-name');
$value = Settings::get('key', 'default');
```

### Delete key from settings
Remove the key from the cache

```php
Settings::forget('key');
```

### Delete all settings
Remove all the keys from the cache

```php
Settings::flush();
```

### Get all settings
Returns all settings stored in key => value array

```php
$settings = Settings::all();
```

### Get value from blade template

```php
<h1>@settings('site-name')</h1>
<h1>@settings('site-name', 'default name')</h1>
```

### Cache all settings
Caches all settings for the duration that has been set in settings.php config file

```bash
php artisan settings:cache
```

### Clear cache for all settings

```bash
php artisan settings:clear
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
