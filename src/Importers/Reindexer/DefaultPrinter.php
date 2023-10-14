<?php

namespace Reindexer\Core\Importers\Reindexer;

use Reindexer\Core\Importers\PrinterInterface;

class DefaultPrinter implements PrinterInterface
{
    public function print(ReIndexRow ...$reIndexRow): void
    {
       foreach ($reIndexRow as $row) {
           echo "{$row->oldId} -> {$row->newId}" . PHP_EOL;
       }
    }
}