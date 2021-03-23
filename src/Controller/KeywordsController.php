<?php

namespace App\Controller;

use App\Entity\Keywords;
use App\Repository\KeywordsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KeywordsController extends AbstractController
{

    /**
     * @var KeywordsRepository
     */
    private KeywordsRepository $repository;

    public function __construct(KeywordsRepository $repository)
    {
        $this->repository = $repository;
    }
//    #[Route('/keywords', name: 'keywords')]
//    public function index(): Response
//    {
//        return $this->render('keywords/index.html.twig', [
//            'controller_name' => 'KeywordsController',
//        ]);
//    }

    /**
     * @Route ("/keywords/add/ajax/{label}", name="keywords.add.ajax", methods={"POST"})
     * @return JsonResponse
     */
    public function addCategoriesAjax(string $label, EntityManagerInterface $entityManagerem): JsonResponse
    {
        $keyword = new Keywords();
        $keyword->setKeyword(trim(strip_tags($label)));
        $entityManagerem->persist($keyword);
        $entityManagerem->flush();
        $id = $keyword->getId();
        return new JsonResponse(['id' => $id]);
    }
}
