<?php

namespace Reindexer\Core\Importers;

class RowCollection
{
    private array $collections = [];

    public function __construct(Row ...$row)
    {
        $this->collections = $row;
    }

    public function getAll(): array
    {
        return $this->collections;
    }

    public function count(): int
    {
        return \count($this->collections);
    }
}