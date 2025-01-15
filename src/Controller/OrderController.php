<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Service\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class OrderController extends AbstractController
{
    #[Route('/commande', name: 'app_order_index')]
    public function index(Request $request,EntityManagerInterface $entityManager,Cart $cart): Response
    {
        // if(!$this->getUser()){
        //     throw new AccessDeniedException("Vous devez être connecté pour passer une commande.");
        // }
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute("");
        }
        return $this->render('order/index.html.twig', [
            'form' =>$form->createView(),
            'RecapCart' => $cart->getCart(),
        ]);


    }
}
