<?php 

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $requestStack;
    private $entityManager;

    // Constructeur pour injecter la session et l'EntityManager
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    // Fonction vide pour ajouter au panier, vous pouvez y ajouter de la logique plus tard
    public function add($product)
    {
        // Appeler la session CART de symfony
        $cart = $this->getCart();

        // Ajouter une qtity +1 à mon produit
        if(isset($cart[$product->getId()]))
        {
            $cart[$product->getId()] = [
                'objet' => $product,
                'qty' => $cart[$product->getId()]['qty'] + 1
            ];
        }else{
            $cart[$product->getId()] = [
                'objet' => $product,
                'qty' => 1
            ];
        }
        // Créer ma session Cart

        $this->requestStack->getSession()->set('cart', $cart);

    }

     // La fonction est actuellement vide. Ajoutez la logique de votre choix ici.

  /*
     * decrease()
     * Fonction permettant la suppression d'une quantity d'un produit au panier
     */

    public function decrease($id)
    {
        $cart = $this->getCart();
        if($cart[$id]['qty'] > 1){
            $cart[$id]['qty'] = $cart[$id]['qty'] - 1;
        }else{
            unset($cart[$id]);
        }

        $this->requestStack->getSession()->set('cart', $cart);
    }


        /*
     * fullQuantity()
     * Fonction retournant le nombre total de produit au panier
     */


    public function fullQuantity()
    {
        $cart = $this->getCart();

        $quantity = 0;

        if(!isset($cart))
        {
            return $quantity;
        }

        foreach($cart as $product)
        {
            $quantity = $quantity + $product['qty'];
        }

        return $quantity;

    }




    /*
     * getTotalWt()
     * Fonction retournant le prix total des produits au panier
     */
    public function getTotalWt()
    {
        $cart = $this->getCart();

        $price = 0;

        if(!isset($cart))
        {
            return $price;
        }

        foreach($cart as $product)
        {
            $price = $price + ($product['objet']->getPrice() * $product['qty']);
        }

        return $price;
    }



        /*
     * remove()
     * Fonction permettant de supprimer totalement le panier
     */


     public function remove()
     {
        return $this->requestStack->getSession()->remove('cart');
     }

     /**
      * getCart()
      * Fonction retournant le panier
      */

      public function getCart()
      {
         return $this->requestStack->getSession()->get('cart');
      }
}


?>
