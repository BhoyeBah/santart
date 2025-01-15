<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article',methods: ['GET','POST'])]
    public function index(ArticleRepository $articleRepository,Request $request,PaginatorInterface $paginatorInterface): Response
    {
        $data = $articleRepository->findBy([], ['createdAt' => 'DESC']);
        $articles = $paginatorInterface->paginate($data, $request->query->getInt('page', 1), 6);
        
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
