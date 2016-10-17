# magento-inventory-update
A simple Magento shell script to update products attributes such as quantity, availability and so on

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

