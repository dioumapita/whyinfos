<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article", methods={"GET"})
     */
    public function index(ArticleRepository $artilce): Response
    {
        $all_article = $artilce->findBy([],['createdAt' => 'desc']);

        return $this->render('article/index.html.twig',compact('all_article'));
    }
    /**
     * @Route("/article/create", name="article-create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $article = new Article;

        $form =  $this->createForm(ArticleType::class,$article);


        $form->handleRequest($request);

        /**
         * on verifit si le formulaire à été soumis et il est valide
         */
        if($form->isSubmitted() && $form->isValid())
            {

               $em->persist($article);
               $em->flush();

               //message flash
               $this->addFlash('success','Article créer avec succès');

                /**
                * on redirige l'utilisateur vers la page qui liste tous les articles
                */

                return $this->redirectToRoute('article');
            }

        return $this->render('article/create.html.twig',[
            'my_form' => $form->createView()
        ]);

       
    }

     /**
     * @Route("/article/show/{id<[0-9+]>}", name="article-show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig',compact('article'));
    }

    /**
     * @Route("/article/edit/{id<[0-9+]>}", name="article-edit", methods={"GET", "PUT"})
     */
    public function edit(Request $request, Article $article, EntityManagerInterface $em)
    {
        $form =  $this->createForm(ArticleType::class,$article,[
            'method' => 'PUT'
        ]);
                        

        $form->handleRequest($request);
        /**
         * on verifit si le formulaire à été soumis et il est valide
         */
        if($form->isSubmitted() && $form->isValid())
            {

               $em->flush();

                //message flash
                $this->addFlash('success','Article modifier avec succès');

                /**
                * on redirige l'utilisateur vers la page qui liste tous les articles
                */
                return $this->redirectToRoute('article');
            }

        return $this->render('article/edit.html.twig',[
            'article' => $article,
            'my_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/delete/{id<[0-9+]>}", name="article-delete")
     */

    public function delete(Article $article, EntityManagerInterface $em)
    {
        $em->remove($article);
        $em->flush();
        
        //message flash
         $this->addFlash('info','Article supprimer avec succès');
        /**
        * on redirige l'utilisateur vers la page qui liste tous les articles
        */
        
            return $this->redirectToRoute('article');
    }
}
