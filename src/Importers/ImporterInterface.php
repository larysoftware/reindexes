<?php

namespace Reindexer\Core\Importers;

interface ImporterInterface
{
    public function import(): RowCollection;
}