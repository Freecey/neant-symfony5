<?php
namespace App\Controller\Profile;

use App\Entity\Articles;
use App\Entity\Comments;
use App\Entity\Users;
use App\Form\CommentsType;
use App\Repository\ArticlesRepository;
use App\Repository\CommentsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentsController extends AbstractController
{

    /**
     * @var CommentsRepository
     */
    private $repository;

    public function __construct(CommentsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/profile/comments", name="profile.comments.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */

    public function index(PaginatorInterface $paginator,Request $request) : Response
    {
        $user = $this->getUser();
//        dd($user);
        $comments = $paginator->paginate($user->getComments(),
//            array(),
//            array('id' => 'DESC'),
//            $limit = 1,
//            5,
//        ),
            $request->query->getInt('page', 1), 10
        );
        return $this->render('profile/comments/index.html.twig', [
            'current_menu' => 'profile_comments',
            'comments' => $comments
        ]);
    }

}