<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SingleArticleController extends AbstractController
{
    #[Route('/detail/article/{id}', name: 'app_single_article', methods: ['GET', 'POST'])]
    public function index(Article $article,CommentaireRepository $commentaireRepository ,Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setCreatedAt(new \DateTimeImmutable());
            $commentaire = $form->getData();
            $commentaire->setArticle($article);

            $entityManager->persist($commentaire);

            $entityManager->flush();

            $this->addFlash('success', 'Commentaire ajouté avec succès.');

            return $this->redirectToRoute('app_single_article', ['id' => $article->getId()]);
        }

        // Récupération des commentaires triés et du nombre total de commentaires
        $articles = $commentaireRepository->findByArticleDesc($article); 
        $nombreCommentaires = $commentaireRepository->countByArticle($article);

        return $this->render('single_article/index.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'commentaires' => $articles,
            'nombreCommentaires' => $nombreCommentaires,
        ]);
    }
}
