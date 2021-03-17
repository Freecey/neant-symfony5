<?php
namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Comments;
use App\Entity\Users;
use App\Form\CommentsType;
use App\Repository\ArticlesRepository;
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

    public function __construct(ArticlesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/articles", name="article.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */

    public function index(PaginatorInterface $paginator,Request $request) : Response
    {
        $articles = $paginator->paginate($this->repository->findBy(
            array(),
            array('id' => 'DESC'),
        ),
        $request->query->getInt('page', 1), 5
        );
        return $this->render('article/index.html.twig', [
            'current_menu' => 'articles',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/articles/{id}-{slug}", name="article.show", requirements={"slug": "[a-z0-9\-]*" })
     * @return Response
     */
    public function show(Articles $article,string $slug, Request $request): Response
    {
        if ($article->getSlug() !== $slug){
            return $this->redirectToRoute('article.show', [
                'id' => $article->getId(),
                'slug' => $article->getSlug()
            ], 301);
        }

        if ($this->isGranted('ROLE_USER') == false) {
            return $this->render('article/show.html.twig',[
                'article' => $article,
                'current_menu' => 'articles',
            ]);
        } else {

        $em=$this->getDoctrine()->getManager();
        $comment = new Comments();
        $currentUser = $this->getUser();

        $comment->addUser($currentUser);
        $form = $this->createForm(CommentsType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment->setArticles($article);
            $comment->setCreatedAt(new \DateTime('now'));

            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($comment);
            $doctrine->flush();
            $newID = $comment->getId();
            return $this->redirectToRoute('article.show', [
                    'id' => $article->getId(),
                    'slug' => $article->getSlug(),
                    '_fragment' => $newID
                ]
            );

        }

        return $this->render('article/show.html.twig',[
            'article' => $article,
            'current_menu' => 'articles',
            'commentForm' => $form->createView()
        ]);
        }
    }

}