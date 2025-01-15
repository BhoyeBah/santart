<?php

namespace App\Twig;

use App\Repository\CategoryRepository;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;


class AppExtensions extends AbstractExtension implements GlobalsInterface
{

    private $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**Methode pour afficher les categorie */
    public function getGlobals(): array
    {
        return [
            "allcategories" => $this->categoryRepository->findAll(),
        ];
    }
}