<?php

namespace App;

use App\exceptions\FromDirectoryIsEmpty;
use App\exceptions\NoWatermarkException;

class Checker
{
    
    public static function perform($fromDirectoryPath, $watermarkImageFilePath)
    {
        if (! glob($watermarkImageFilePath . '.*')[0]) {
            throw new NoWatermarkException('There is no watermark file!');
        }
        if (! glob($fromDirectoryPath . '/*')) {
            throw new FromDirectoryIsEmpty;
        }
    }
}