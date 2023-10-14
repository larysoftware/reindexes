<?php

namespace Reindexer\Core\Wholesales\Example;

use Reindexer\Core\Importers\Row;
use Reindexer\Core\Importers\RowCollection;
use Reindexer\Core\Importers\XmlImporter;

class NewFile extends XmlImporter
{
    public function import(): RowCollection
    {
        $arrayRow = [];
        $data = $this->getFileData();
        foreach ($data->products->product as $product) {
            $ean = (string)$product->attributes()->code_on_card;
            $id = (string)$product->attributes()->id;
            $arrayRow[] = new Row($id, $ean);
        }
        return new RowCollection(...$arrayRow);
    }
}