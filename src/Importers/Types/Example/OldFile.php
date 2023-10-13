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

        $lightData = array(); // Data from XML type=light
        foreach($xml->offer[1]->products->product as $p)
        {
            $id = intval($p->attributes()->id);
            $lightData[$id]['vat'] = (string) $p->price->attributes()->vat;
            $lightData[$id]['gross'] = (string) $p->price->attributes()->gross;
            $lightData[$id]['amount'] = intval($p->sizes->size->stock->attributes()->quantity);
            if ( $lightData[$id]['amount'] < 0 ) // IOF -1 is infinity
                $lightData[$id]['amount'] += 10000;
            $lightData[$id]['ean'] = '';
            if (!empty($p->sizes->size) && !empty($p->sizes->size->attributes()->code_producer))
            {
                $lightData[$id]['ean'] = (string)($p->sizes->size->attributes()->code_producer);
            }
        }
        unset($xml->offer[1]);

        foreach($xml->offer->products->product as $p)
        {
            $id = intval($p->attributes()->id);
            $p->addChild('id', (string)($p->attributes()->id));
            $p->addChildWithCDATA('code_producer', (string) $p->attributes()->code_producer);
            $p->addChildWithCDATA('producer_name', (string)($p->producer->attributes()->name));
            $p->addChildWithCDATA('category_path', (string)($p->category->attributes()->name));
            $p->addChildWithCDATA('unit_name', (string)($p->unit->attributes()->name));
            $name = ( $pol = $p->description->xpath('name[@xml:lang="pol"]') ) ? (string)($pol[0]) : '';
            $p->addChildWithCDATA('name_pl', $name);
            $desclong = ( $pol = $p->description->xpath('long_desc[@xml:lang="pol"]') ) ? (string)($pol[0]) : '';
            $p->addChildWithCDATA('desclong_pl', $desclong);
            $desc = ( $pol = $p->description->xpath('short_desc[@xml:lang="pol"]') ) ? (string)($pol[0]) : '';
            $p->addChildWithCDATA('desc_pl', $desc);

            if ( isset($lightData[$id]) && isset($lightData[$id]['vat']) )
            {
                $p->addChildWithCDATA('vat', $lightData[$id]['vat']);
                $p->addChildWithCDATA('gross', $lightData[$id]['gross']);
                $p->addChildWithCDATA('ean', $lightData[$id]['ean']);
            }
            else
            {
                $p->addChildWithCDATA('vat', $p->price->attributes()->vat);
                $p->addChildWithCDATA('gross', $p->price->attributes()->gross);

                if (!empty($p->sizes->size) && !empty($p->sizes->size->attributes()->code_producer))
                {
                    $p->addChildWithCDATA('ean', (string)($p->sizes->size->attributes()->code_producer));
                }
            }
            $p->addChildWithCDATA('amount', isset($lightData[$id]) && isset($lightData[$id]['amount']) ? $lightData[$id]['amount'] : 0);
        }
        unset($lightData);

        return $xml;

    }
}