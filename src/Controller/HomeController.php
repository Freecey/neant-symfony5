<?php
namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * @param ArticlesRepository $repository
     * @return Response
     */

    public function index(ArticlesRepository $repository): Response
    {
        $articles = $repository->findBy(
            array(),
            array('id' => 'DESC'),
            $limit = 5,
        );
        return $this->render('pages/home.html.twig', [
            'current_menu' => 'home',
            'articles' => $articles
        ]);
    }
}