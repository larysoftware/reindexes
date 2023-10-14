<?php

namespace Reindexer\Core\Importers\Exceptions;

class ImporterClassNotExistException extends \Exception
{
    public function __construct(string $importer)
    {
        parent::__construct("Importer class {$importer} not exist");
    }
}