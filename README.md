# BooBoo Pretty Page formatter

[![Latest Version](https://img.shields.io/github/release/thephpleague/booboo-pretty.svg?style=flat-square)](https://github.com/thephpleague/booboo-pretty/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/thephpleague/booboo-pretty.svg?style=flat-square)](https://travis-ci.org/thephpleague/booboo-pretty)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/thephpleague/booboo-pretty.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/booboo-pretty)
[![Quality Score](https://img.shields.io/scrutinizer/g/thephpleague/booboo-pretty.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/booboo-pretty)
[![HHVM Status](https://img.shields.io/hhvm/league/booboo-pretty.svg?style=flat-square)](http://hhvm.h4cc.de/package/league/booboo-pretty)
[![Total Downloads](https://img.shields.io/packagist/dt/league/booboo-pretty.svg?style=flat-square)](https://packagist.org/packages/league/booboo-pretty)

**PrettyPage formatter for BooBoo.**


## Install

Via Composer

``` bash
$ composer require league/booboo-pretty
```


## Usage

This package ports the Pretty Page handler from the popular [Whoops!](http://filp.github.io/whoops/) to [BooBoo](http://booboo.thephpleague.com/).

Some tweaks that are newly added:

- Stylesheets are compiled from LESS
- Assets are compiled from composer packages
- Tables can be added as objects (Array and callable sources are supported out-of-the-box)


### Framework integration

As the original one handler, this one is also designed to work as is (without any further modification/integration required). However it has two main downsides:

- Assets must be dumped to the page (which is not a big issue in development environment, but still ugly)
- The ZeroClipboard flash must be linked from CDN so that it can work without placing any files in the public directory

These can be pretty big issues.


## Testing

``` bash
$ phpunit
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

- [Márk Sági-Kazár](https://github.com/sagikazarmark)
- [All Contributors](https://github.com/thephpleague/booboo-pretty/contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
