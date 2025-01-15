<?php

namespace App\Controller\Admin;

use App\Entity\Categorieblog;
use App\Form\CategorieblogType;
use App\Repository\CategorieblogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/categorieblog')]
final class CategorieblogController extends AbstractController
{
    #[Route(name: 'app_categorieblog_index', methods: ['GET'])]
    public function index(CategorieblogRepository $categorieblogRepository): Response
    {
        return $this->render('backend/categorieblog/index.html.twig', [
            'categorieblogs' => $categorieblogRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_categorieblog_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorieblog = new Categorieblog();
        $form = $this->createForm(CategorieblogType::class, $categorieblog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorieblog);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorieblog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/categorieblog/new.html.twig', [
            'categorieblog' => $categorieblog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorieblog_show', methods: ['GET'])]
    public function show(Categorieblog $categorieblog): Response
    {
        return $this->render('backend/categorieblog/show.html.twig', [
            'categorieblog' => $categorieblog,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorieblog_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categorieblog $categorieblog, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieblogType::class, $categorieblog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_categorieblog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/categorieblog/edit.html.twig', [
            'categorieblog' => $categorieblog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorieblog_delete', methods: ['POST'])]
    public function delete(Request $request, Categorieblog $categorieblog, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieblog->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($categorieblog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_categorieblog_index', [], Response::HTTP_SEE_OTHER);
    }
}
