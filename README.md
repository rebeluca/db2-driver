# DB2 for IBM iSeries Laravel Driver

This package allows you to use Laravel's query builder and eloquent with DB2 for IBM iSeries by extending the Illuminate Database component of the Laravel framework. Originally forked
from [BWICompanies/db2-driver](https://github.com/BWICompanies/db2-driver).

## Requirements

- PHP PDO_DB2 extension
- IBM i Series server

## Installation

Install the package via composer:

```bash
composer require rebeluca/db2-driver
```

Add a new connection in `database.php`:
> Note: You can specify the connection name, but the driver must be 'db2'

```php
'mydb2connection' => [
    'driver'     => 'db2',
    'driverName' => env('DB_DRIVENAME', 'ibm:IASP01'),
    'database'   => '',
    'username'   => env('DB_USERNAME', ''),
    'password'   => env('DB_PASSWORD', ''),
    'options'    => [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
    ],
],
```

> Note: Be sure to define the appropriate keys in `.env`.

## Other Resources

- [DB2 Connection String Keywords](https://www.ibm.com/docs/fr/i/7.3?topic=details-connection-string-keywords)
- [PDO Attributes](https://www.w3resource.com/php/pdo/php-pdo.php)
- [ACS / IBM i Access Driver Release Notes](https://www.ibm.com/support/pages/ibm-i-access-acs-updates-pase)
- [Seiden Group](https://www.seidengroup.com/blog/)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
