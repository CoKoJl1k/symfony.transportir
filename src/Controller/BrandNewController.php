<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrandNewController extends AbstractController
{
    /**
     * @Route("/brand/new", name="app_brand_new")
     */
    public function index(): Response
    {
        return $this->render('brand_new/index.html.twig', [
            'controller_name' => 'BrandNewController',
        ]);
    }
}
