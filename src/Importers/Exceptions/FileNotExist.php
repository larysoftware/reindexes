<?php

namespace Reindexer\Core\Importers\Exceptions;

class FileNotExist extends \Exception
{
    public function __construct(string $file = "")
    {
        parent::__construct("File {$file} not exist");
    }
}