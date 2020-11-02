<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(ArticleRepository $article): Response
    {
        $all_article = $article->findBy([],['createdAt' => 'desc'],3);

        return $this->render('pages/index.html.twig',compact('all_article'));
    }

    /**
     * @Route("/presentation", name="presentation", methods={"GET"})
     */

    public function presentation(): Response
    {
        return $this->render('pages/presentation.html.twig');
    }

    /**
     * @Route("/about", name="about", methods={"GET"})
     */

    public function about(): Response
    {
        return $this->render('pages/about.html.twig');
    }

}
