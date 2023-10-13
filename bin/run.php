<?php

require __DIR__ . '/../vendor/autoload.php';
$result = \Reindexer\Core\Importers\Reindexer\Processor::create(
    new \Reindexer\Core\Importers\Types\GiftWorld\NewFile(__DIR__ . '/../../gitft_word/full_new.xml'),
    new \Reindexer\Core\Importers\Types\GiftWorld\OldFile(__DIR__ . '/../../gitft_word/full_old.xml')
)->run();
foreach ($result as $result) {
    echo $result->oldId . ' -> ' . $result->newId . PHP_EOL;
}