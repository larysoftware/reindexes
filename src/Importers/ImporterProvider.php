<?php

namespace Reindexer\Core\Importers;

use Reindexer\Core\Importers\Reindexer\DefaultPrinter;

class ImporterProvider
{
    public function __construct(private ImporterInterface $newFileImporer, private ImporterInterface $oldFileImporter, private ?PrinterInterface $printer)
    {
    }

    public function getNewImporter(): ImporterInterface
    {
        return $this->newFileImporer;
    }

    public function getOldImporert(): ImporterInterface
    {
        return $this->oldFileImporter;
    }

    public function getPrinter(): PrinterInterface
    {
        return $this->printer ?: new DefaultPrinter();
    }
}