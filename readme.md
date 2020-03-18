# Laravel Qonto

[![Latest Version on Packagist][ico-version]][link-packagist]
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

This package provide you a simple way to sync your [Qonto bank account(s)](https://qonto.eu) and transaction(s) into your database, throught Qonto API and an artisan command. 

## Requirements

This package requires **PHP 7.2**, **Laravel 5.8** or higher and a database already set up in your Laravel project.

## Installation

Install this package via Composer :

``` bash
$ composer require brocorp/qonto
```

Edit your .ENV file and add theses lines :

```
QONTO_LOGIN=your_qonto_login
QONTO_SECRET=your_qonto_secret_key
```

Obviously, we know you're a smart dev, but don't forget to replace `your_qonto_login` and `your_qonto_login` with your own Qonto credentials! 

> Wait! Where to find/generate them? 

Simply check [the "Getting Started" page](https://api-doc.qonto.eu/2.0/welcome/get-started) on Qonto.eu and follow instructions.

Last step, run `php artisan qonto:install` which will perform a migration and running a first full sync into your database.

That's all! 

## Usage, scheduling

Well, you can issue this artisan command to sync your latest 100 transactions for each bank accounts

``` bash
$ php artisan qonto:sync
```

but in most cases you’ll probably want to schedule these commands because it's typicaly boring to type daily this command and it's totally normal, you're not weirdo. This command can be scheduled in `app/Console/Kernel.php` :

``` php
protected function schedule(Schedule $schedule)
{
    $schedule->command('qonto:sync')->daily()->at('12:00');
}
```

Of course, feel free to consult official [Laravel documentation about scheduling](https://laravel.com/docs/master/scheduling#introduction) to adjust it for your own need.

## Changelog

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

Tests aren't writted yet, and we apologize. 

## Contributing

Please see [contributing.md](contributing.md) for details.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [brocorp](https://www.brocorp.re)
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/brocorp/qonto.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/brocorp/qonto.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/brocorp/qonto
[link-downloads]: https://packagist.org/packages/brocorp/qonto
[link-author]: https://github.com/brocorp
[link-contributors]: ../../contributors
