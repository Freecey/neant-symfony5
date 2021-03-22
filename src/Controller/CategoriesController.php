<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $categories = $paginator->paginate($this->repository->findBy(
            array(),
            array('name' => 'ASC'),
        ),
            $request->query->getInt('page', 1), 12
        );

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



}
