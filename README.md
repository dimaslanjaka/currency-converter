# currency-converter
Currency Converter Tools

### Build
```sh
composer install
```

### Usage
```php
require __DIR__.'/vendor/autoload.php'; //your vendor autoload.php
use \Curl\CC;

// Object Oriented
$c = new CC();
$c->set('USD');
$c->build()->get_data();

// ... Chaining Oriented Method
$c = new CC()->set('USD')->build()->get_data();
```

### Description
```php
$c = new CC();

//Set Source Currency
$c->set('USD'); // Set source currency from USD

//Build Repo
$c->build();

//Get Data repo
$c->get_data();

//Converting to available Currency
$c->convert(1, 'EUR'); //convert 1 USD to EUR

//Refresh Repo
$c->refresh();

//Get Available Currency Converter For Source Currency
$c->available();

//Get Result
echo $c->__toString();
```