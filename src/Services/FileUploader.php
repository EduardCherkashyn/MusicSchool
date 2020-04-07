<?php
namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;
    private $assetDirectory;

    public function __construct($targetDirectory, $assetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
        $this->assetDirectory = $assetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function uploadAsset(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        try {
            $file->move($this->getAssetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    public function getAssetDirectory()
    {
        return $this->assetDirectory;
    }
}
