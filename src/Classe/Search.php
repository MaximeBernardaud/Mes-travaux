<?php
  namespace App\Classe;
  
  use App\Entity\Category;

  class Search {
    public ?string $string = '';
    public Category|array $categories= [];
  }