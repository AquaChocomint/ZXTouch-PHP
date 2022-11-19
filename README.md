# ZXTouch-PHP

A library to communicate with ZXTouch written in PHP

## General

This library enables to communicate with [ZXTouch](https://github.com/xuan32546/IOS13-SimulateTouch) Tweak in PHP language. 

## Installation

This library requires php 8.0 or higher. The recommended way to install ZXTouch-PHP is Composer.

```bash
$ composer require aquachocomint/zxtouch-php
```

## Basic Usage

```php

require 'vendor/autoload.php';

$zxtouch = new \zxtouch\ZXTouch("127.0.0.1"); //Connect to the device that is running ZXTouch
$coords = new \zxtouch\element\Coordinates(500, 750);

//Touch a screen
$zxtouch->touch(new \zxtouch\element\touch\TouchDown(1, $coords));
usleep(800000); //Wait for 0.8 seconds
$zxtouch->touch(new \zxtouch\element\touch\TouchUp(1, $coords));
$zxtouch->disconnect(); //Disconnect from the device
```

## Documentation

Please see the source code as it is self-documented (I will write soon).