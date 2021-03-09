<?php
namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleController extends AbstractController
{
    /**
     * @param ArticleRepository $repository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $am;

    public function __construct(ArticleRepository $repository, EntityManagerInterface $am)
    {
        $this->repository = $repository;
        $this->am = $am;
    }

    /**
     * @Route("/admin/article", name="admin.article.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $articles = $this->repository->findAll();
        return $this->render('admin/article/index.html.twig', compact('articles'));
    }

    /**
     * @Route ("/admin/article/create", name="admin.article.new")
     */
    public function new(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->am->persist($article);
            $this->am->flush();
            $this->addFlash('success','Article Add Successfully');
            return $this->redirectToRoute('admin.article.index');
        }

        return $this->render('admin/article/new.html.twig', [
            'article'   => $article,
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/article/edit/{id}", name="admin.article.edit", methods="GET|POST")
     * @param Article $article
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Article $article, Request $request)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->am->flush();
            $this->addFlash('success','Article Updated Successfully');
            return $this->redirectToRoute('admin.article.index');
        }

        return $this->render('admin/article/edit.html.twig', [
            'article'   => $article,
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/article/delete/{id}", name="admin.article.delete", methods="DELETE")
     * @param Article $article
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function delete(Article $article, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->get('_token'))){
//              $this->am->remove($article);
//              $this->am->flush();
            $this->addFlash('success','Article Deleted Successfully');
            return new Response('Deleted');
        }
        return $this->redirectToRoute('admin.article.index');
    }
}
