<?php
namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleController extends AbstractController
{
    /**
     * @param ArticleRepository $repository
     */
    private $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin", name="admin.article.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $articles = $this->repository->findAll();
        return $this->render('admin/article/index.html.twig', compact('articles'));
    }

    /**
     * @Route("/admin/article/{id}", name="admin.article.edit")
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Article $article)
    {
//        $form = $this->createForm(ArticleType::class, $article);
        $form = $this->createForm(ArticleType::class, $article);
        return $this->render('admin/article/edit.html.twig', [
            'article'   => $article,
            'form'      => $form->createView()
        ]);
    }
}
