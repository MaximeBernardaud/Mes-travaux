<?php
  namespace App\Classe;
  
  use App\Entity\Product;
  use Doctrine\ORM\EntityManagerInterface;
  use Symfony\Component\HttpFoundation\Session\SessionInterface;

  class Cart
  {
    private SessionInterface $session;
    private EntityManagerInterface $entityManager;
  
    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
      $this->session = $session;
      $this->entityManager = $entityManager;
    }
    
    public function getFull(): array
    {
      $cartComplete = [];
  
      foreach ($this->get() as $id => $quantity) {
        $cartComplete[] = [
          'product' => $this->entityManager->getRepository(Product::class)->findOneBy(['id' =>$id]),
          'quantity'=> $quantity
        ];
      }
      
      return $cartComplete;
    }
    
    public function add($id)
    {
      $cart = $this->session->get('cart', []);
      
      if (!empty($cart[$id])) {
        $cart[$id]++;
      } else {
        $cart[$id] = 1;
      }
      
      $this->session->set('cart', $cart);
    }

    public function minus($id)
    {
      $cart = $this->session->get('cart', []);

      if ($cart[$id] > 1) {
        $cart[$id]--;
      } else {
        unset($cart[$id]);
      }
      
      $this->session->set('cart', $cart);
    }

    public function delete($id)
    {
      $cart = $this->session->get('cart', []);
      unset($cart[$id]);
      
      return $this->session->set('cart', $cart);
    }
    
    public function get()
    {
      if ($this->session->get('cart') === null) {
        $getReturn = [];
      } else {
        $getReturn = $this->session->get('cart');
      }
      return $getReturn;
    }

    public function remove()
    {
      return $this->session->remove('cart');
    }


  }