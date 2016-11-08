[![SensioLabsInsight](https://insight.sensiolabs.com/projects/626c5e9c-d1a7-4c35-875f-74f27aed83f0/small.png)](https://insight.sensiolabs.com/projects/626c5e9c-d1a7-4c35-875f-74f27aed83f0)
[Faktiva "Magento inventory update"](https://github.com/faktiva/magento-inventory-update)
===

[![GitHub release](https://img.shields.io/github/release/faktiva/magento-inventory-update.svg?style=flat&label=latest)](https://github.com/faktiva/magento-inventory-update/releases/latest)
[![Project Status](http://opensource.box.com/badges/active.svg?style=flat)](http://opensource.box.com/badges)
[![Percentage of issues still open](http://isitmaintained.com/badge/open/faktiva/magento-inventory-update.svg?style=flat)](http://isitmaintained.com/project/faktiva/magento-inventory-update "Percentage of issues still open")
[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/faktiva/magento-inventory-update.svg?style=flat)](http://isitmaintained.com/project/faktiva/magento-inventory-update "Average time to resolve an issue")
[![composer.lock](https://poser.pugx.org/faktiva/magento-inventory-update/composerlock?style=flat)](https://packagist.org/packages/faktiva/magento-inventory-update)
[![Dependencies Status](https://img.shields.io/librariesio/github/faktiva/magento-inventory-update.svg?maxAge=3600&style=flat)](https://libraries.io/github/faktiva/magento-inventory-update)
[![License](https://img.shields.io/packagist/l/faktiva/magento-inventory-update.svg?style=flat)](https://creativecommons.org/licenses/by-sa/4.0/)

[![Join the chat at https://gitter.im/faktiva/magento-inventory-update](https://img.shields.io/badge/Gitter-CHAT%20NOW-brightgreen.svg?style=flat)](https://gitter.im/faktiva/magento-inventory-update)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/faktiva/magento-inventory-update.svg?style=social)](https://twitter.com/intent/tweet?text=See this "%23Magento inventory update" script from %23Faktiva&url=https://github.com/faktiva/magento-inventory-update)

____

**A simple Magento shell script to update products attributes such as quantity, availability and so on**

## install

### using composer
Add the following to your composer.json
```json
    "require": {
        "faktiva/magento-inventory-update": "^1.0"
    },
    "scripts": {
        "post-install-cmd": [
            "Faktiva\\MagentoInventoryUpdate\\Installer::install"
        ]
    },
    "extra": {
        "magento-scripts-dir": "httpdocs/shell"
    }
```
Then run `composer install` to have the script installed in the Magento "_`shell`_" dir, indicated by "__magento-scripts-dir__".

### manually
Simply download the `shell/inventory_update.php` script in the Magento "_`shell`_" dir. Get it from the [latest release](https://github.com/faktiva/magento-inventory-update/releases/latest)

___

If you want to install the script under a different path you have to adjust the path to the log file and to Magento's `Mage_Shell_Abstract` class (it is in the `shell/abstract.php` file).

