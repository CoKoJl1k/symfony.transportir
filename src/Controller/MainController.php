<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="mobile_homepage", host="m.example.com")
     */

    public function mobileHomepage(): Response
    {
        dd('mobileHomepage');
    }

    /**
     * @Route("/main", name="homepage")
     */
    public function homepage(): Response
    {
        /*
        $name = 'hello';
// creates a simple Response with a 200 status code (the default)
        $response = new Response('Hello '.$name, Response::HTTP_OK);

// creates a CSS-response with a 200 status code
        $response = new Response('<style> ... </style>');
        $response->headers->set('Content-Type', 'text/css');
        return $response;*/

        //$contentsDir = $this->getParameter('kernel.project_dir').'/contents';
//dd($contentsDir);
        //return $this->file($this->getParameter('kernel.project_dir').'/var/1.jpg');
        $articles = ['hello'=>array('slug'=>1,'title'=>2),'hello2'=>array('slug'=>3,'title'=>4)];

        $title = 'Main';
        return $this->render('main/index.html.twig', [
            'title' => $title,
            'articles' => $articles
        ]);
    }
}