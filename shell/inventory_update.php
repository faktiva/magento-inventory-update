<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');
ini_set('log_errors', 1);
ini_set('error_log', __DIR__.'/var/log/products_update.log');

require_once __DIR__.'/abstract.php';

/**
 * Inventory update shell script.
 *
 * @author "Emiliano Gabrielli" <emiliano.gabrielli@gmail.com>
 */
class Faktiva_Shell_Inventory_Update extends Mage_Shell_Abstract
{
    const CSV_DELIMITER = ',';
    const CSV_ENCLOSURE = '"';
    const CSV_SKU_COLUMN = 0;
    const CSV_QTY_COLUMN = 1;

    const STATUS_FLAG_LT = '-';  // lower then
    const STATUS_FLAG_EQ = '=';  // equal
    const STATUS_FLAG_GT = '+';  // greater then
    const STATUS_FLAG_404 = '?'; // not found
    const STATUS_FLAG_405 = '!'; // not allowed

    protected $dryrun = false;

    protected static function _getStatusSymbol($old, $new)
    {
        $diff = (int) $new - (int) $old;

        if (0 === $diff) {
            return self::STATUS_FLAG_EQ;
        }

        return ($diff > 0) ? self::STATUS_FLAG_GT : self::STATUS_FLAG_LT;
    }

    /**
     * Run script.
     */
    public function run()
    {
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

        // --dry-run
        if (''!=$this->getArg('dry-run')) {
            $this->dryrun = true;
            echo "\n\n--> DRY-RUN: nothing will be actually done on the underlying DB <--";
        }
        echo "\n\n";

        // -f <csvfile>
        if (!is_string($csvfile = $this->getArg('f'))) {
            die($this->usageHelp());
        }

        $fh = fopen($csvfile, 'r');
        while ($line = fgetcsv($fh, 8000, self::CSV_DELIMITER, self::CSV_ENCLOSURE)) {
            $sku = $line[self::CSV_SKU_COLUMN];
            $qty = $line[self::CSV_QTY_COLUMN];

            if ($qty < 0) {
                printf("[%s] Product '%s' has a negative new quantity (%d). Skipped.\n", self::STATUS_FLAG_405, $sku, $qty);
                continue;
            }

            $product = Mage::getModel('catalog/product')
                ->loadByAttribute('sku', $sku);
            if (!$product) {
                printf("[%s] Product '%s' does not exists. Skipped.\n", self::STATUS_FLAG_404, $sku);
                continue;
            }
            $stockItem = Mage::getModel('cataloginventory/stock_item')
                    ->loadByProduct($product);

            // qty
            $old_qty = $stockItem->getQty();
            $stockItem->setData('qty', $qty);
            // in stock
            $stockItem->setData('is_in_stock', ($qty > 0 ? 1 : 0));

            if (!$this->dryrun) {
                $stockItem->save(); // actually save to DB
            }

            printf("[%s] Inventory updated for product '%s'. (%d -> %d)\n",
                    self::_getStatusSymbol($old_qty, $qty),
                    $sku,
                    $old_qty,
                    $qty
            );

            $product->clearInstance();
            unset($product);
            $stockItem->clearInstance();
            unset($stockItem);
        }
        fclose($fh);
        echo "\n";
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
    --dry-run              Do not actually do anything on the underlying DB

    -h, help               This help


USAGE;
    }
}

$shell = new Faktiva_Shell_Inventory_Update();
$shell->run();
