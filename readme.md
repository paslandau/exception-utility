#exception-utility
[![Build Status](https://travis-ci.org/paslandau/exception-utility.svg?branch=master)](https://travis-ci.org/paslandau/exception-utility)

Library to extend PHP core functions by common (missing) functions to deal with exceptions

##Description
[todo]

##Requirements

- PHP >= 5.5

##Installation

The recommended way to install exception-utility is through [Composer](http://getcomposer.org/).

    curl -sS https://getcomposer.org/installer | php

Next, update your project's composer.json file to include ExceptionUtility:

    {
        "repositories": [
            {
                "type": "git",
                "url": "https://github.com/paslandau/exception-utility.git"
            }
        ],
        "require": {
             "paslandau/exception-utility": "~0"
        }
    }

After installing, you need to require Composer's autoloader:
```php

require 'vendor/autoload.php';
```