<?php

namespace App\Controller;

use App\Service\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Cart $cart): Response
    {
        return $this->render('home/index.html.twig', [
            'fullQuantity' => $cart->fullQuantity(),
        ]);
    }
}
