<?php
namespace App\Controller\Admin;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="admin.index")
     */

    public function index()
    {
        return $this->render('admin/index.html.twig');
    }
}
