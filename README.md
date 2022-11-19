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
$coords = new \zxtouch\element\Coordinates(500, 750); //We will touch the screen at this point

//Touch a screen
$zxtouch->touch(new \zxtouch\element\touch\TouchDown(1, $coords));
usleep(800000); //Wait for 0.8 seconds
$zxtouch->touch(new \zxtouch\element\touch\TouchUp(1, $coords));

//But you can tap a screen without these codes. Just call `\zxtouch\ZXTouch::tap()` method. (required v1.2.0 or higher)

$zxtouch->getConnection()->disconnect(); //Disconnect from the device
```

## Documentation

This documentation doesn't show all the functions. To get more information, please see the source code as it is self-documented.

### ZXTouch

First, you need to create `zxtouch\ZXTouch` instance to control your device. You can create an instance like:

```php
$zxtouch = new \zxtouch\ZXTouch("127.0.0.1"); //"127.0.0.1" is the ip address to connect the device
```

### Tap a screen

You can tap your device using the `\zxtouch\ZXTouch::tap()` method.

```php
$point = new \zxtouch\element\Coordinates(20, 50); //We will tap this point
$zxtouch->tap($point);
```

### Getting Screen Size Information

You can get the screen size information using the `\zxtouch\ZXTouch::getScreenSize()` method.

```php
$screen = $zxtouch->getScreenSize(); //This will return \zxtouch\result\ScreenSizeResult
var_dump($screen->getWidth(), $screen->getHeight()); //It will print width and height information
```