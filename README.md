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
```bash
$ php artisan vendor:publish --provider=Merodiro\Settings\SettingsServiceProvider
```
## Usage

### Set settings
It creates a record if the key doesn't exist or update it if the key exists and update the cache

```php
Settings::set('key', 'value');
Settings::set('key', 'another value');
```

### Get value from settings
It caches settings automatically
and it returns its value if it exists or the second parameter if it doesn't exist

```php
$name = Settings::get('site-name');
$value = Settings::get('key', 'default');
```

### Delete key from settings
It also removes it from cache

```php
Settings::forget('key');
```

### Delete all settings
It also removes them from cache

```php
Settings::flush();
```

### Get all settings
returns all settings stored in key => value array
```php
$settings = Settings::all();
```

### Cache all settings
it caches all settings for the duration in settings.php config file

```bash
php artisan settings:cache
```

### Clear cache for all settings

```bash
php artisan settings:clear
```

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
