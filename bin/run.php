<?php

require __DIR__ . '/../vendor/autoload.php';
$arguments = $_SERVER['argv'];
$wholesale = $arguments[2] ?? null;
$newFile = $arguments[3] ?? null;
$oldFile = $arguments[4] ?? null;
Reindexer\Core\Importers\Reindexer\App::create(
    \Reindexer\Core\Importers\ImporterProviderBuilder::createByWholesale($wholesale, $newFile, $oldFile)
)->run();
