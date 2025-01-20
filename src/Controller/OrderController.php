<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use App\Service\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/commande', name: 'app_order')]
    public function index(Request $request, Cart $cart,EntityManagerInterface $entityManager): Response
    {
        $products = $cart->getCart();
        $order = new Order();

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $order = $order->setCreatedAt(new \DateTime());
            $order->setPrixtotal($cart->getTotalWt());

            foreach ($products as $product){
                $orderDetail = new OrderDetails();
                $orderDetail = $orderDetail->setProductname($product['objet']->getName());
                $orderDetail = $orderDetail->setPrix($product['objet']->getPrice());
                $orderDetail = $orderDetail->setQuantity($product['qty']);
                $orderDetail = $orderDetail->setImage($product['objet']->getImage());
                $order->addOrderDetail($orderDetail);
            }

//            dd($orderDetail,$order);
            $entityManager->persist($order);
            $entityManager->flush();
        }
        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $products,
            'order' => $order,
            'total' => $cart->getTotalWt(),
        ]);
    }
}
