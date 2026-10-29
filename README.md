# ZKTeco Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ajangsupardi/zkteco-laravel.svg?style=flat-square)](https://packagist.org/packages/ajangsupardi/zkteco-laravel)
[![PHP Version Require](https://img.shields.io/packagist/php-v/ajangsupardi/zkteco-laravel.svg?style=flat-square)](https://packagist.org/packages/ajangsupardi/zkteco-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/ajangsupardi/zkteco-laravel.svg?style=flat-square)](https://packagist.org/packages/ajangsupardi/zkteco-laravel)
[![License MIT](https://img.shields.io/packagist/l/ajangsupardi/zkteco-laravel.svg?style=flat-square)](https://packagist.org/packages/ajangsupardi/zkteco-laravel)

Laravel package for ZKTeco biometric attendance devices. Multi-device support with database storage and Artisan sync command.

## Features

- Multi-device support via `zkteco_devices` table
- Migrations & Eloquent models for devices, users, attendance
- Artisan command `zkteco:sync` for automated sync
- Service Provider & Facade

## Requirements

- PHP ^8.2
- ext-sockets
- Laravel ^11.0|^12.0|^13.0

## Installation

```bash
composer require ajangsupardi/zkteco-laravel
php artisan migrate
```

## Usage

Add device:
```php
use Rynest\Zkteco\Models\ZktecoDevice;
ZktecoDevice::create(['name'=>'main_gate','ip'=>'192.168.1.8','port'=>4370]);
```

Sync:
```bash
php artisan zkteco:sync --all
```

Query:
```php
use Rynest\Zkteco\Models\ZktecoAttendance;
$logs = ZktecoAttendance::with('device')->get();
```

## Changelog

See [CHANGELOG.md](CHANGELOG.md)

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md)

## License

MIT. See [LICENSE](LICENSE).
