<?php
namespace App\Controller\Profile;

use App\Entity\Articles;
use App\Entity\Comments;
use App\Entity\Users;
use App\Form\ArticlesType;
use App\Form\CommentsType;
use App\Repository\ArticlesRepository;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{

    /**
     * @var ArticlesRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ArticlesRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/profile/articles", name="profile.articles.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */

    public function index(PaginatorInterface $paginator,Request $request) : Response
    {
        $user = $this->getUser();
        $articles = $paginator->paginate($this->repository->findBy(
            array(),
            array('id' => 'DESC'),
            $limit = null,
        ),
            $request->query->getInt('page', 1), 10
        );
        return $this->render('profile/articles/index.html.twig', [
            'current_menu' => 'profile_articles',
            'articles' => $articles
        ]);
    }

    /**
     * @Route ("/profile/articles/create", name="profile.articles.new")
     */
    public function new(Request $request)
    {
        $articles = new Articles();
        $form = $this->createForm(ArticlesType::class, $articles);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($articles);
            $this->em->flush();
            $this->addFlash('success','Article Add Successfully');
            return $this->redirectToRoute('profile.articles.index');
        }

        return $this->render('profile/articles/new.html.twig', [
            'article'   => $articles,
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/profile/articles/edit/{id}", name="profile.articles.edit", methods="GET|POST")
     * @param Articles $articles
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Articles $articles, Request $request)
    {
        $form = $this->createForm(ArticlesType::class, $articles);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success','Article Updated Successfully');
            return $this->redirectToRoute('profile.articles.index');
        }

        return $this->render('profile/articles/edit.html.twig', [
            'article'   => $articles,
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/profile/articles/delete/{id}", name="profile.articles.delete", methods="DELETE")
     * @param Articles $articles
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function delete(Articles $articles, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $articles->getId(), $request->get('_token'))){
              $this->em->remove($articles);
//              $this->em->flush();
            $this->addFlash('success','Article Deleted Successfully');
            return new Response('Deleted');
        }
        return $this->redirectToRoute('profile.articles.index');
    }


}