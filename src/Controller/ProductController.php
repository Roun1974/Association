<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Product;

class ProductController extends AbstractController
{
     /**
     * @Route("/products/{slug}", name="product_show")
     */
    public function showAction(Product $product)
    {
        $products = $this->get('shopping_cart')->getProducts();
        
        return $this->render('product/show.html.twig', array(
            'product' => $product
        ));
    }

    /**
     * @Route("/pricing", name="pricing_show")
     */
    public function pricingAction()
    {
        return $this->render('product/pricing.html.twig', array(
        ));
    }
}
