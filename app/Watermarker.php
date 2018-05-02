<?php

namespace App;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class Watermarker
{
    
    public static function handle($fromDirectoryPath, $toDirectoryPath, $watermarkImageFilePath, $watermarkSize)
    {
        self::checkIfEverytingIsOk($fromDirectoryPath, $watermarkImageFilePath);
        self::removeEverythingInToDirectory($toDirectoryPath);
        self::watermark($fromDirectoryPath, $toDirectoryPath, $watermarkImageFilePath, $watermarkSize);
    }
    
    protected static function checkIfEverytingIsOk($fromDirectoryPath, $watermarkImageFilePath)
    {
        Checker::perform($fromDirectoryPath, $watermarkImageFilePath);
    }
    
    protected static function removeEverythingInToDirectory($toDirectoryPath)
    {
        Remover::allInDirectory($toDirectoryPath);
    }
    
    protected static function watermark($fromDirectoryPath, $toDirectoryPath, $watermarkImageFilePath, $watermarkSize)
    {
        $manager = new ImageManager(array('driver' => 'gd'));
        $images = ImageFiles::getFrom($fromDirectoryPath);
        foreach ($images as $image) {
            $image = self::initializeImageProcessing($manager, $image);
            $watermarkHeight = self::calculateHeightOfWatermark($watermarkSize, $image);
            $watermark = self::initializeWatermark($watermarkImageFilePath, $manager);
            self::resizeWatermark($watermark, $watermarkHeight);
            self::inserWatermarkAndSave($toDirectoryPath, $image, $watermark);
        }
    }
    
    protected static function initializeImageProcessing(ImageManager $manager, $image)
    {
        $image = $manager->make($image);
        
        return $image;
    }
    
    protected static function calculateHeightOfWatermark($watermarkSize, Image $image)
    {
        $watermarkHeight = ($watermarkSize * $image->getHeight()) / 100;
        
        return $watermarkHeight;
    }
    
    protected static function initializeWatermark($watermarkImageFilePath, ImageManager $manager)
    {
        $watermark = $manager->make(glob($watermarkImageFilePath . '.*')[0]);
        
        return $watermark;
    }
    
    protected static function resizeWatermark(Image $watermark, $watermarkHeight)
    {
        $watermark->resize(null, $watermarkHeight, function ($constraint) {
            $constraint->aspectRatio();
        });
    }
    
    protected static function inserWatermarkAndSave($toDirectoryPath, Image $image, Image $watermark)
    {
        $image->insert($watermark, 'bottom-right');
        $image->save($toDirectoryPath . '/' . $image->filename . '.jpg');
    }
}