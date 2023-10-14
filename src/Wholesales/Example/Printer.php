<?php

namespace Reindexer\Core\Wholesales\Example;

use Reindexer\Core\Importers\PrinterInterface;
use Reindexer\Core\Importers\Reindexer\ReIndexRow;

class Printer implements PrinterInterface
{
    public function print(ReIndexRow ...$reIndexRow): void
    {
        foreach ($reIndexRow as $row) {
            echo "{$row->oldId} -> {$row->newId}" . PHP_EOL;
        }
    }
}