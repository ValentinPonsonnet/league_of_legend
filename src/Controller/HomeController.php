<?php

namespace App\Controller;

use App\Entity\News;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * Affichage par défaut
     * @Route("/", name="home")
     */

    public function acceuil(NewsRepository $newsRepository): Response
    {
        $news = $newsRepository->findLastNews(10);
        return $this->render('home/acceuil.html.twig',[
            'lastNews' => $news 
        ]);
    }

    /**
     * Affichage du blog
     * @Route("/blog", name="blog")
     */
    public function blog(NewsRepository $allArticle): Response
    {   
        $news = $allArticle->findArticle(3);
        return $this->render('home/blog.html.twig',[
                'allNews' => $news
            ]);
    }

    /**
     * Affichage d'une vue
     * @Route("/post/{id}", name="one_article")
     */
    public function one_article(News $article)
    {
        return $this->render('home/one_article.html.twig', [
            'article' => $article
        ]);
    }
}
