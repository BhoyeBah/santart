<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class OrderController extends AbstractController
{
    #[Route('/admin/commande', name: 'app_order_index')]
    public function index(OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findAllOrderedByDate();
        return $this->render('backend/order/index.html.twig', [
            'orders' => $order,
        ]);
    }


    #[Route('/admin/commande/{id}', name: 'app_order_show')]
    public function show(Order $order): Response
    {

        return $this->render('backend/order/show.html.twig', [
            'order' => $order,
        ]);
    }
}
