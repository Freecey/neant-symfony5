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
            array('Users' => $user),
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
//        $nextid = $this->repository->findNextId();
//        dd($nextid);
//        die();
        $articles = new Articles();
        $user = $this->getUser();
        $userid = $user->getId();
        $form = $this->createForm(ArticlesType::class, $articles, [
            'option_var' => $userid,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articles->setUsers($user);
            $articles->setIsvalidated(false);
            $this->em->persist($articles);
            $this->em->flush();
            $this->addFlash('success','Article successfully added, but it must be validated by the site manager before it is visible to others.');
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
        $user = $this->getUser()->getId();
        $userArticle = $articles->getUsers()->getId();
//        dd($user);
//        die();
        if ($userArticle !== $user)
        {
            return $this->redirectToRoute('profile.articles.index');
        }

        $form = $this->createForm(ArticlesType::class, $articles, [
            'option_var' => $user,
        ]);
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
        $user = $this->getUser()->getId();
        $userArticle = $articles->getUsers()->getId();
//        dd($user);
//        die();
        if ($userArticle !== $user)
        {
            return $this->redirectToRoute('profile.articles.index');
        }
        if ($this->isCsrfTokenValid('delete' . $articles->getId(), $request->get('_token'))){
              $this->em->remove($articles);
              $this->em->flush();
            $this->addFlash('success','Article Deleted Successfully');
            return $this->redirectToRoute('profile.articles.index');
//            return new Response('Deleted');
        }
        return $this->redirectToRoute('profile.articles.index');
    }


}