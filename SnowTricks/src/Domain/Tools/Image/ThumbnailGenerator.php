<?php


namespace App\Domain\Tools\Image;


class ThumbnailGenerator
{

    public function build($image, $targetDirectory, $imageName, $imageExtension, $thumbnailWidth, $thumbnailHeight)
    {

        // get dimension of original image
        list($originalWidth, $originalHeight) = getimagesize($image);

        // get original ratio
        $ratio = $originalWidth/$originalHeight;

        // choose which given value of the canvas (width or height) should be modified to respect the original ratio
        if ($thumbnailWidth/$thumbnailHeight > $ratio)
        {
            $thumbnailWidth = $thumbnailHeight*$ratio;
        }
        else
        {
            $thumbnailHeight = $thumbnailWidth/$ratio;
        }

        // create the new (blank) image with the wishing dimensions
        $newImage = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);

        // transform object to ressource
        // create file and move to directory
        if ($imageExtension == 'jpeg' || $imageExtension == 'jpg')
        {
            $image = imagecreatefromjpeg($image);
        }
        else
        {
            $image = imagecreatefrompng($image);
        }

        // execute resizing
        imagecopyresampled($newImage, $image,  0, 0, 0, 0, $thumbnailWidth, $thumbnailHeight, $originalWidth, $originalHeight);

        // create final file and move to directory
        imagejpeg($newImage, $targetDirectory . '/' . $imageName . '.' . $imageExtension);
    }


}