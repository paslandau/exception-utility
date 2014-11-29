#ExceptionUtility
[![Build Status](https://travis-ci.org/paslandau/ExceptionUtility.svg?branch=master)](https://travis-ci.org/paslandau/ExceptionUtility)

Library to extend PHP core functions by common (missing) functions to deal with exceptions

##Description
[todo]

##Requirements

- PHP >= 5.5

##Installation

The recommended way to install ExceptionUtility is through [Composer](http://getcomposer.org/).

    curl -sS https://getcomposer.org/installer | php

Next, update your project's composer.json file to include ExceptionUtility:

    {
        "repositories": [
            {
                "type": "git",
                "url": "https://github.com/paslandau/ExceptionUtility.git"
            }
        ],
        "require": {
             "paslandau/ExceptionUtility": "~0"
        }
    }

After installing, you need to require Composer's autoloader:
```php

require 'vendor/autoload.php';
```