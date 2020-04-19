# currency-converter
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fdimaslanjaka%2Fcurrency-converter.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Fdimaslanjaka%2Fcurrency-converter?ref=badge_shield)

Currency Converter Tools

# Get Script Project

```sh
git clone https://github.com/dimaslanjaka/currency-converter.git
```

### Requirement Build

[Composer](https://getcomposer.org/download/)

### Build
```sh
composer install
```

### EXAMPLE -> Access Folder Test

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
//your vendor autoload.php
require __DIR__.'/vendor/autoload.php';

//Use Class
use \Curl\CC;

//Initialize Currency Converter Class
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

# Install Currency-Converter On termux

```sh
#!/data/data/com.termux/files/usr/bin/sh
pkg up -y
pkg install curl php git -y
#begin install Composer

curl -sS https://getcomposer.org/installer | php -- --install-dir=/data/data/com.termux/files/usr/bin --filename=composer

#verify Composer
composer

#Clone Currency Converter

git clone https://github.com/dimaslanjaka/currency-converter.git

#cd folder currency-converter
cd currency-converter

#Install library
composer install

#Run currency Converter
php -S localhost:8000

#open browser http://localhost:8000/test
#for out from termux php server
#CTRL+C on your termux tab runner
```

## License
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fdimaslanjaka%2Fcurrency-converter.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fdimaslanjaka%2Fcurrency-converter?ref=badge_large)