<?php

namespace Reindexer\Core\Importers\Types\Example;

use Reindexer\Core\Importers\Row;
use Reindexer\Core\Importers\RowCollection;
use Reindexer\Core\Importers\XmlImporter;

class OldFile extends XmlImporter
{
    public function import(): RowCollection
    {
        $rows = [];
        $xml = $this->prepareData();

        foreach ($xml->offer->products->product as $product) {
            $id = (string)$product->id;
            $ean = (string)$product->ean;
            $rows[] = new Row($id, $ean);
        }

        return new RowCollection(...$rows);
    }


    private function prepareData(): \SimpleXMLElement
    {
        $xml = $this->getFileData();


        return $xml;

    }
}