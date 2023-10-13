<?php

namespace Reindexer\Core\Legacy;

class SimpleXMLElementExtended extends \SimpleXMLElement
{
    public function addChildWithCDATA($name, $value = null)
    {
        $new_child = $this->addChild((string)$name);
        if ($new_child !== null) {
            $node = dom_import_simplexml($new_child);
            $no = $node->ownerDocument;
            $node->appendChild($no->createCDATASection((string)$value));
        }
        return $new_child;
    }
}