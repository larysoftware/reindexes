<?php

namespace Reindexer\Core\Importers;

use Reindexer\Core\Importers\Exceptions\FileNotExist;
use Reindexer\Core\Legacy\SimpleXMLElementExtended;

abstract class XmlImporter implements ImporterInterface
{
    private string $file;

    public function __construct(string $file)
    {
        if (!file_exists($file)) {
            throw new FileNotExist($file);
        }
        $this->file = $file;
    }

    public function import(): RowCollection
    {
        return new RowCollection();
    }

    protected function getFileData(): ?SimpleXMLElementExtended
    {
        $element = \simplexml_load_file($this->file, SimpleXMLElementExtended::class);
        return $element ?: null;
    }
}