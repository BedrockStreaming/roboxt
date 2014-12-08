Roboxt
======

Roboxt is a PHP robots.txt file parser.

## Usage

```php

    # Create a Parser instance
    $parser = new \Roboxt\Parser();

    # Parse your robots.txt file
    $file = $parser->parse("http://www.google.com/robots.txt");

    # You can verify that an url is allowed by a specific user agent
    $tests = [
        ["/events", "*"],
        ["/search", "*"],
        ["/search", "badbot"],
    ];

    foreach ($tests as $test) {
        list($url, $agent) = $test;
        if ($file->isUrlAllowedByUserAgent($url, $agent)) {
            echo "\n ✔ $url is allowed by $agent";
        } else {
            echo "\n ✘ $url is not allowed by $agent";
        }
    }

    # You can also iterate over all user agents specified by the robots.txt file
    # And check the type of each directive
    foreach ($file->allUserAgents() as $userAgent) {
        echo "\n Agent {$userAgent->getName()}: \n";

        foreach ($userAgent->allDirectives() as $directive) {
            if ($directive->isDisallow()) {
                echo "  ✘ {$directive->getValue()} \n";
            } else if ($directive->isAllow()) {
                echo "  ✔ {$directive->getValue()} \n";
            }
        }
    }

```

## Installation

The recommended way to install Roboxt is through [Composer](http://getcomposer.org/):

```
$> composer require m6web/roboxt
```

## Running the Tests

Roboxt uses [PHPSpec](http://www.phpspec.net/) for the unit tests:

```bash
$> composer install --dev

$> ./vendor/bin/phpspec run
```

## Credits

 * M6Web
 * [@benja-M-1](https://github.com/benja-M-1) and [@theodo](https://github.com/theodo)

## License

Roboxt is released under the MIT License.
