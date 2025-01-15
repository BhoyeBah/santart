<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart): Response
    {

        return $this->render('cart/index.html.twig',[
            'cart' => $cart->getCart(),
            'total' => $cart->getTotalWt(),
            'fullQuantity' => $cart->fullQuantity(),
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, Cart $cart, ProductRepository $productRepository,Request $request): Response
    {

        $product = $productRepository->findOneById($id);
        $cart->add($product);
        // dd($cart,$product,$id);
        // return $this->redirect($request->headers->get('referer'));
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/cart/decrease/{id}', name: 'app_cart_decrease')]
    public function decrease(int $id, Cart $cart): Response
    {
        $cart->decrease($id);
        // dd($cart,$product,$id);
        // return $this->redirect($request->headers->get('referer'));
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove', name: 'app_cart_remove')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('app_home');
    }

    
}
