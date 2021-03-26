<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotNull;

class CategoriesController extends AbstractController
{

    /**
     * @var CategoriesRepository
     */
    private CategoriesRepository $repository;

    public function __construct(CategoriesRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/categories', name: 'categories.index')]
    public function index(PaginatorInterface $paginator,Request $request): Response
    {
        $categories = $paginator->paginate($this->repository->
        findCategoriesNotEmpty(),
//        findBy(
//            array(),
//            array('name' => 'ASC'),
//        ),
            $request->query->getInt('page', 1), 12
        );
        dd($categories);
        die();
        return $this->render('categories/index.html.twig', [
            'current_menu' => 'categories',
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/categories/{slug}", name="category.show", requirements={"slug": "[a-z0-9\-]*" })
     * @return Response
     */
    public function show(Categories $categories,string $slug, Request $request): Response
    {
        if ($categories->getSlug() !== $slug) {
            return $this->redirectToRoute('category.show', [
                'slug' => $categories->getSlug()
            ]
                , 301);
        }

        return $this->render('categories/show.html.twig',[
            'category' => $categories,
            'current_menu' => 'categories',
        ]);
    }

    /**
     * @Route ("/categories/add/ajax/{label}", name="categoies.add.ajax", methods={"POST"})
     * @return Response
     */
    public function addCategoriesAjax(string $label, EntityManagerInterface $entityManagerem): Response
    {
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];

        $category = new Categories();
        $category->SetName(trim(strip_tags($label)));
        $category->setColor($color);
        $entityManagerem->persist($category);
        $entityManagerem->flush();
        $id = $category->getId();
        return new JsonResponse(['id' => $id]);
    }


}
