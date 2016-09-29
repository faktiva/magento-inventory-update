<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');
ini_set('log_errors', 1);
ini_set('error_log', __DIR__.'/log/products_update.log');

require_once __DIR__.'/abstract.php';

/**
 * Inventory update shell script.
 *
 * @author "Emiliano Gabrielli" <emiliano.gabrielli@gmail.com>
 */
class Shell_Inventory_Update extends Mage_Shell_Abstract
{
    const CSV_DELIMITER = ',';
    const CSV_ENCLOSURE = '"';
    const CSV_SKU_COLUMN = 0;
    const CSV_QTY_COLUMN = 1;

    /**
     * Run script.
     */
    public function run()
    {
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

        // -f <csvfile>
        if (!is_string($csvfile = $this->getArg('f'))) {
            die($this->usageHelp());
        }

        $fh = fopen($csvfile, 'r');
        while ($line = fgetcsv($fh, 8000, self::CSV_DELIMITER, self::CSV_ENCLOSURE)) {
            $sku = $line[self::CSV_SKU_COLUMN];
            $qty = $line[self::CSV_QTY_COLUMN];

            $product = Mage::getModel('catalog/product')
                ->loadByAttribute('sku', $sku);
            if ($product) {
                $stockItem = Mage::getModel('cataloginventory/stock_item')
                    ->loadByProduct($product);

                // qty
                $old_qty = $stockItem->getQty();
                $stockItem->setData('qty', $qty);

                // in stock
                $stockItem->setData('is_in_stock', ($qty > 0 ? 1 : 0));

                //FIXME $stockItem->save();
                unset($stockItem);

                printf("Inventory updated for product '%s' [%d -> %d]\n", $sku, $old_qty, $qty);
            } else {
                printf("Product '%s' does not exists. Skipped.\n", $sku);
            }
            unset($product);
        }
        fclose($fh);
    }

    /**
     * Retrieve Usage Help Message.
     */
    public function usageHelp()
    {
        global $argv;

        return <<<USAGE
Usage:  php {$argv[0]} -- [options]

    -f <file_path>         A CSV file with SKU and updates

    -h, help               This help


USAGE;
    }
}

$shell = new Shell_Inventory_Update();
$shell->run();
