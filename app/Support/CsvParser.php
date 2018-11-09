<?php
/**
 * Created by PhpStorm.
 * User: imac
 * Date: 09.11.2018
 * Time: 11:50
 */

namespace App\Support;

use League\Csv\Reader;

class CsvParser {

    private $parseArray;

    /**
     * Parse bank invoices
     *
     * @return array of contract/summ
     */
    public static function parseInvoices($file_path) {

        $file = Reader::createFromPath($file_path, 'r');
        $file->setDelimiter(';');

        $records = $file->getRecords();

        foreach ($records as $offset => $record) {

            //Получаем только ключевые объекты
            if(count($record) == 13 && $record[0] !== 'Buchungstag' && $record[1] !== '') {



                if(preg_match('([0-9]{10}-[0-9]{2})', $record[8], $matches)) {

                    $contract_number = $matches[0];
                    $amount = (int)$record[11];


                    $parseArray[$contract_number] = $amount;



                }

            }

        }

        return $parseArray;

    }

}