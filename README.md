# Eloquent changelog

Provides laravel eloquent compatible table changes logger. For more information about changelog implementation, go to [https://packagist.org/packages/drewlabs/changelog].

# Usage

To register eloquent changelog driver, simply add the provided service provider in your laravel application configuration:

````php
// config/app.php
return [
    // ...

    'providers' => [
        // ...
        \Drewlabs\Changelog\Eloquent\ServiceProvider::class,
        // ...
    ]
];

```

The library comes with a command for creating logs table in your application database. In order to run the migration:

> php artisan changelog:migrate --refresh --connection=<DATABASE_CONNECTION_NAME>

**Note** By default, the command use `mysql` connection if no connection option is passed.


**Note** The above configuration allows you to easily log table changes in your application.

- Loggable trait

The library also comes with a handy trait that can be added to your eloquent model that allows them to log their changes using configured drivers. To provide a model with the logging abilities on changes:

```php
<?php
// ...
use Drewlabs\Changelog\Eloquent\Loggable;
use Drewlabs\Changelog\Loggable as AbstractLoggable;

class MyModel implements AbstractLoggable {
	use Loggable;

    
    // This method is required by the model and should return the table name used when
    // logging the model changes into storage
    public function getLogTableName(): string
	{
		return sprintf("locations.%s", $this->getTable());
	}
}
```