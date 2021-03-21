<?php
namespace App\Controller\Profile;

use App\Entity\Articles;
use App\Entity\Comments;
use App\Entity\Users;
use App\Form\CommentsType;
use App\Repository\ArticlesRepository;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    private $em;

    public function __construct(CommentsRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
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

    /**
     * @Route("/profile/comments/edit/{id}", name="profile.comments.edit", methods="GET|POST")
     * @param Comments $comments
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Comments $comments, Request $request)
    {
        $user = $this->getUser()->getId();
        $userComment = $comments->getUser()->getValues()[0]->getId();
//        dd($user);
//        die();
        if ($userComment !== $user)
        {
            return $this->redirectToRoute('profile.comments.index');
        }

        $form = $this->createForm(CommentsType::class, $comments);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success','Comment Updated Successfully');
            return $this->redirectToRoute('profile.comments.index');
        }

        return $this->render('profile/comments/edit.html.twig', [
            'comments'   => $comments,
            'form'      => $form->createView()
        ]);
    }

    /**
     * @Route("/profile/comments/delete/{id}", name="profile.comments.delete", methods="DELETE")
     * @param Comments $comments
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function delete(Comments $comments, Request $request)
    {
        $user = $this->getUser()->getId();
        $userComment = $comments->getUser()->getValues()[0]->getId();
//        dd($user);
//        die();
        if ($userComment !== $user)
        {
            return $this->redirectToRoute('profile.comments.index');
        }
        if ($this->isCsrfTokenValid('delete' . $comments->getId(), $request->get('_token'))){
            $this->em->remove($comments);
              $this->em->flush();
            $this->addFlash('success','Comment Deleted Successfully');
            return $this->redirectToRoute('profile.comments.index');
        }
        return $this->redirectToRoute('profile.comments.index');
    }

}