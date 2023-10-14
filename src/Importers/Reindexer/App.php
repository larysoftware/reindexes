<?php

namespace Reindexer\Core\Importers\Reindexer;

use Reindexer\Core\Importers\ImporterProvider;

class App
{
    public static function create(ImporterProvider $importerProvider): self
    {
        return new self($importerProvider);
    }

    private function __construct(private ImporterProvider $importerProvider)
    {
    }

    public function run(): void
    {
        try {
            $this->importerProvider->getPrinter()->print(
                ...Processor::create(
                    $this->importerProvider->getNewImporter(),
                    $this->importerProvider->getOldImporert()
                )->run()
            );
        } catch (\Exception $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
    }
}