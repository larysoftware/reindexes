<?php

require __DIR__ . '/../vendor/autoload.php';
$result = \Reindexer\Core\Importers\Reindexer\Processor::create(
    new \Reindexer\Core\Importers\Types\Example\NewFile(__DIR__ . 'full_new.xml'),
    new \Reindexer\Core\Importers\Types\Example\OldFile(__DIR__ . 'full_old.xml')
)->run();
foreach ($result as $result) {
    echo $result->oldId . ' -> ' . $result->newId . PHP_EOL;
}