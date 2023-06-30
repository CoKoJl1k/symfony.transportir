<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\File;

class FileService
{

    public function saveFile(object $entity, File $file, string $path): object
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($path, $fileName);
        $entity->setFile($fileName);
        return $entity;
    }
}