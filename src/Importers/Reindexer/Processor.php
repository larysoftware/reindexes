<?php

namespace Reindexer\Core\Importers\Reindexer;

use Reindexer\Core\Importers\ImporterInterface;
use Reindexer\Core\Importers\RowCollection;

class Processor
{
    public static function create(ImporterInterface $importerNewFile, ImporterInterface $importerOldFile)
    {
        return new self($importerNewFile, $importerOldFile);
    }
    private function __construct(private ImporterInterface $importerNewFile, private ImporterInterface $importerOldFile)
    {
    }

    public function run(): array
    {
        $newDataCollection = $this->importerNewFile->import();
        $oldDataCollection = $this->importerOldFile->import();
        if (!$newDataCollection->count() || !$oldDataCollection->count()) {
            return [];
        }

        $oldDataTmp = $this->replaceToAsociative($oldDataCollection);


        $reindexRow = [];
        foreach ($newDataCollection->getAll() as $newData) {
            if (empty($newData->id) || empty($newData->compareValue)) {
                continue;
            }
            $oldData = $oldDataTmp[$newData->compareValue] ?? null;
            if ($oldData) {
                $reindexRow[] = new ReIndexRow($oldData->id, $newData->id);
            }
        }
        return $reindexRow;
    }

    private function replaceToAsociative(RowCollection $rowCollection): array
    {
        $dataTmp = [];
        foreach ($rowCollection->getAll() as $data) {
            if (empty($data->compareValue) || empty($data->id)) {
                continue;
            }
            $dataTmp[$data->compareValue] = $data;
        }
        return $dataTmp;
    }
}