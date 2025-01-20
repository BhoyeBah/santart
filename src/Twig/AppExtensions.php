<?php

namespace App\Twig;

use App\Repository\CategoryRepository;
use App\Service\Cart;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;


class AppExtensions extends AbstractExtension implements GlobalsInterface
{

    private $categoryRepository;
    private $cart;
    public function __construct(CategoryRepository $categoryRepository, Cart $cart)
    {
        $this->categoryRepository = $categoryRepository;
        $this->cart = $cart;
    }

    /**Methode pour afficher les categorie */
    public function getGlobals(): array
    {
        return [
            "allcategories" => $this->categoryRepository->findAll(),
            "fullquantity" => $this->cart->fullQuantity(),
        ];
    }
}