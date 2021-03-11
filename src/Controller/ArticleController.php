<?php
namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @var ArticleRepository
     */
    private $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/articles", name="article.index")
     * @return Response
     */

    public function index() : Response
    {
        $allArticles = $this->repository->findCatOther();
        dump($allArticles);
        return $this->render('article/index.html.twig', [
            'current_menu' => 'articles'
        ]);
    }

    /**
     * @Route("/articles/{id}-{slug}", name="article.show", requirements={"slug": "[a-z0-9\-]*" })
     * @return Response
     */
    public function show(Article $article,string $slug): Response
    {
        if ($article->getSlug() !== $slug){
            return $this->redirectToRoute('article.show', [
                'id' => $article->getId(),
                'slug' => $article->getSlug()
            ], 301);
        }
        return $this->render('article/show.html.twig',[
            'article' => $article,
            'current_menu' => 'articles'
        ]);
    }

}