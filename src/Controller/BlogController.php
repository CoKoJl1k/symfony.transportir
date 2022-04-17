<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog/{page}", name="blog_index", defaults={"page": 1, "title": "Hello world!"})
     */
    public function index(int $page, string $title, Request $request): Response
    {
        //$routeParameters = $request->attributes->get('_route_params');
        //dd($routeParameters);
        $number =  1;
        //$title = 'dsadas';
        return $this->render('blog/index.html.twig', [
            'number' => $number,
            'title' => $title
        ]);
    }

    /**
     * @Route("/list", name="blog_list",priority="2")
     */
    public function list(Request $request): Response
    {
        $routeName = $request->attributes->get('_route');
        $routeParameters = $request->attributes->get('_route_params');
        //dd($routeParameters);
        // use this to get all the available attributes (not only routing ones):
        $allAttributes = $request->attributes->all();
        dd($allAttributes);
    }

    /**
     * @Route("/list", name="blog_list2",priority="0")
     */

    public function list2(Request $request): Response
    {
        $routeName = $request->attributes->get('_route');
        dd($routeName);
    }
    /**
     * @Route("/blog_slug/{slug}", name="blog_show")
     */
    public function show(string $slug): Response
    {
         return $this->render('blog/show.html.twig', [
                      'slug' => $slug
        ]);
    }
}