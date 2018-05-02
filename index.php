<?php

require('vendor/autoload.php');

use App\Watermarker;

$fromDirectoryPath = 'from';
$toDirectoryPath = 'to';
$watermarkImageFilePath = 'watermark';
$watermarkSize = '9';

Watermarker::handle($fromDirectoryPath, $toDirectoryPath, $watermarkImageFilePath, $watermarkSize);