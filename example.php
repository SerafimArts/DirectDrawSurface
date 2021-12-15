<?php

declare(strict_types=1);

use Serafim\DDS\Reader;

require __DIR__ . '/vendor/autoload.php';

$reader = new Reader();

// DXT1 (BC1 RGB)
var_dump($reader->fromPathname(__DIR__ . '/samples/dxt1.dds'));

// DXT3 (BC2 RGBA)
var_dump($reader->fromPathname(__DIR__ . '/samples/dxt3.dds'));

// DXT5 (BC3 RGBA)
var_dump($reader->fromPathname(__DIR__ . '/samples/dxt5.dds'));

// DXT1 (BC1 RGB) + DX10 header
var_dump($reader->fromPathname(__DIR__ . '/samples/dxt1dx10.dds'));


