<?php
// src/Controller/SecurityController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(LoggerInterface $logger): Response
    {
        $logger->info('We are logging!');
        $title = 'Login';
        return $this->render('login/index.html.twig', [
            'title' => $title
        ]);
    }
}