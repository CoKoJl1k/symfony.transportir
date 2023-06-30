<?php
namespace App\Service;

use App\Entity\Claims;

class FileService
{
    public function getHappyMessage(): string
    {
        $messages = [
            'You did it! You updated the system! Amazing!',
            'That was one of the coolest updates I\'ve seen all day!',
            'Great work! Keep going!',
        ];

        $index = array_rand($messages);

        return $messages[$index];
    }

    public function saveFile(Claims $claim, $file, $path): Claims
    {
        //$path = $this->getParameter('kernel.project_dir')."/public/uploads/claims";
        //$file = $form['file']->getData();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($path, $fileName);
        $claim->setFile($fileName);
        return $claim;
    }
}