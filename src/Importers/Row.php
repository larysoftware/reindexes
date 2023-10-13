<?php

namespace Reindexer\Core\Importers;

class Row
{
    public readonly string|int $id;
    public readonly string|int $compareValue;
    public function __construct(string|int $id, string|int $compareValue)
    {
        $this->id = $id;
        $this->compareValue = $compareValue;
    }

    public function compare(Row $row): bool
    {
        return $row->compareValue === $this->compareValue;
    }
}