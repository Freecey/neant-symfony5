<?php
namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @param ArticleRepository $repository
     * @return Response
     */

    public function index(ArticleRepository $repository): Response
    {
        $articles = $repository->find5Latest();
        return $this->render('pages/home.html.twig', [
            'current_menu' => 'home',
            'articles' => $articles
        ]);
    }
}