<?php

/*
 * This file is part of the Faktiva "Magento inventory update" package.
 *
 * (c) Faktiva (http://faktiva.com)
 *
 * NOTICE OF LICENSE
 * This source file is subject to the CC BY-SA 4.0 license that is
 * available at the URL https://creativecommons.org/licenses/by-sa/4.0/
 *
 * DISCLAIMER
 * This code is provided as is without any warranty.
 * No promise of being safe or secure
 *
 * @author   Emiliano 'AlberT' Gabrielli <albert@faktiva.com>
 * @license  https://creativecommons.org/licenses/by-sa/4.0/  CC-BY-SA-4.0
 * @source   https://github.com/faktiva/php-admin-tk
 */

namespace Faktiva\MagentoInventoryUpdate;

use Composer\Script\Event;

class Installer
{
    public static function install(Event $event)
    {
        $extras = $event->getComposer()->getPackage()->getExtra();
        if (empty($extras['magento-scripts-dir'])) {
            throw new \Exception('Missing "magento-scripts-dir" in composer.json "extra"');
        }
        $install_dir = $extras['magento-scripts-dir'];

        copy(__DIR__.'/shell/inventory_update.php', "./$install_dir/inventory_update.php");
    }
}
