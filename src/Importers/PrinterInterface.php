<?php

namespace Reindexer\Core\Importers;

use Reindexer\Core\Importers\Reindexer\ReIndexRow;

interface PrinterInterface
{
    public function print(ReIndexRow ...$reIndexRow): void;
}