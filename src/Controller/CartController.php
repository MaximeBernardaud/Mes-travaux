<?php

namespace App\Controller;

use App\Classe\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'cart')]
    public function index(Cart $cart): Response
    {
      return $this->render('cart/index.html.twig', [
        'cart' => $cart->getFull()
      ]);
    }

    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, $id): Response
    {
      $cart->add($id);
      
      return $this->redirectToRoute('cart');
    }

    #[Route('/cart/minus/{id}', name: 'minus_to_cart')]
    public function minus(Cart $cart, $id): Response
    {
      $cart->minus($id);
      
      return $this->redirectToRoute('cart');
    }

    #[Route('/cart/delete/{id}', name: 'delete_to_cart')]
    public function delete(Cart $cart, $id): Response
    {
      $cart->delete($id);
      
      return $this->redirectToRoute('cart');
    }

    #[Route('/cart/remove', name: 'remove_my_cart')]
    public function remove(Cart $cart): Response
    {
      $cart->remove();
      
      return $this->redirectToRoute('products');
    }
}
