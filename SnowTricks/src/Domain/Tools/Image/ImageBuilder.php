<?php

namespace App\Domain\Tools\Image;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageBuilder
{

    public function  buildImageName()
    {
        return $fileName = md5(uniqid());

    }

    public function guessExtension(UploadedFile $file)
    {
        return $file->guessExtension();
    }


    public function upload(UploadedFile $file, $fileName)
    {
        $file->move($this->getTargetDirectory(), $fileName);
        return $fileName;
    }

}