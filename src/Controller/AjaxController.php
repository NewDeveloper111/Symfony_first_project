<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//#[Route('/ajax')]
class AjaxController extends AbstractController
{
    #[Route('/get/{id}', name: 'app_ajax_get', methods: ['GET'])]
    public function showByGET(Article $article): Response
    {
        return $this->json($article->getContent());
    }
        
//    #[Route('/post/{id}', name: 'app_ajax_post', methods: ['POST'])]
//    public function showByPOST(Article $article): Response
//    {
//        return $this->json($article->getContent());
//    }
    #[Route('/post', name: 'app_ajax_post', methods: ['POST'])]
    public function showByPOST(ArticleRepository $articlerepository, Request $request): Response
    {
        $id = $request->request->get('id');
        $content = $articlerepository->find($id)->getContent();
        return $this->json($content);
    }
}