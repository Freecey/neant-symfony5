<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("/articles", name="article.index")
     * @return Response
     */

    public function index() : Response
    {
        return $this->render('article/index.html.twig', [
            'current_menu' => 'articles'
        ]);
    }

}