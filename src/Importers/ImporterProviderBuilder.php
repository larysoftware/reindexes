<?php

namespace Reindexer\Core\Importers;

use Reindexer\Core\Importers\Exceptions\ImporterClassNotExistException;

class ImporterProviderBuilder
{
    public static function createByWholesale(?string $wholesale, ?string $newFile, ?string $oldFile): ImporterProvider
    {
        if (empty($wholesale) || empty($newFile) || empty($oldFile)) {
            throw new \Exception('unless arguments');
        }

        $wholesale = ucwords($wholesale);
        $newFileImporterClass = "Reindexer\Core\Wholesales\\{$wholesale}\NewFile";
        $oldFileImporterClass = "Reindexer\Core\Wholesales\\{$wholesale}\OldFile";
        $printerClass = "Reindexer\Core\Wholesales\\{$wholesale}\Printer";

        if (!class_exists($newFileImporterClass)) {
            throw new ImporterClassNotExistException($newFileImporterClass);
        }

        if (!class_exists($oldFileImporterClass)) {
            throw new ImporterClassNotExistException($oldFileImporterClass);
        }

        return new ImporterProvider(new $newFileImporterClass($newFile), new $oldFileImporterClass($oldFile), class_exists($printerClass) ? new $printerClass : null);
    }
}