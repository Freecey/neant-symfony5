<?php

namespace App\Controller;

use App\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    /**
     * @Route ("/sitemap.xml", name="sitemap", defaults={"_format"="xml"})
     */
    public function index(Request $request)
    {
        $hostname = $request->getSchemeAndHttpHost();
        $urls = [];

        $urls[] = ['loc' => $this->generateUrl('home')];
        $urls[] = ['loc' => $this->generateUrl('about.index')];
        $urls[] = ['loc' => $this->generateUrl('app_login')];
        $urls[] = ['loc' => $this->generateUrl('app_register')];
        $urls[] = ['loc' => $this->generateUrl('article.index')];

        foreach($this->getDoctrine()->getRepository(Articles::class)->findAll() as $article){
            $images = [
                'loc' => 'uploads/images/featured/'. $article->getFeaturedImage(),
                'title' => $article->getTitle(),
            ];
            $urls[] = [
                'loc' => $this->generateUrl('article.show', [
                    'id' => $article->getId(),
                    'slug' => $article->getSlug()
                ]),
                'image' => $images,
                'lastmod' => $article->getUpdatedAt()->format('Y-m-d')
            ];
        }
//        dd($urls);

        $response = new Response(
            $this->renderView('sitemap/index.html.twig', [
                'urls' => $urls,
                'hostname' => $hostname
            ]),
            200
        );

        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
