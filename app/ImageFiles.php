<?php

namespace App;

class ImageFiles
{
    
    public static function getFrom($fromDirectoryPath)
    {
        return glob($fromDirectoryPath . '/*.{png,jpg,jpeg,bmp,PNG,JPG,JPEG,BMP}', GLOB_BRACE);
    }
}