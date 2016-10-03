<?php

namespace Faktiva\MagentoInventoryUpdate;

use Composer\Script\Event;

class Installer
{
    public static function install(Event $event)
    {
        $extras = $event->getComposer()->getPackage()->getExtra();
        if ( empty($extras['magento-scripts-dir']) ) {
            throw new \Exception('Missing "magento-scripts-dir" in composer.json "extra"');
        }
        $install_dir = $extras['magento-scripts-dir'];

        copy(__DIR__.'/shell/inventory_update.php', "./$install_dir/inventory_update.php");
    }
}
