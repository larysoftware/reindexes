<?php

namespace Reindexer\Core\Importers\Reindexer;

readonly class ReIndexRow
{
    public function __construct(public int|string $oldId, public int|string $newId)
    {
    }
}