<?php
namespace App\Service;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ConsoleController extends AbstractController
{

    public function __construct(private ArticleRepository $article) {
        
    }

    public function getAllArticles(): Response
    {
        $articles = $this->article->findAll();
        $context = [
            'circular_reference_handler' => fn(object $obj): string =>
            get_class($obj) == 'App\Entity\Article' ? $obj->getTitle() : $obj->getName(),
            'enable_max_depth' => true
        ];
        return $this->json($articles, 200, [], $context);
    }
}