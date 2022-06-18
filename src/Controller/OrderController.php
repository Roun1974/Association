<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class OrderController extends AbstractController
{
   /**
     * @Route("/checkout", name="order_checkout")
     * @Security("is_granted('ROLE_USER')")
     */
    public function checkoutAction(Request $request): Response
    {
        

        return $this->render('order/checkout.html.twig', [
            'controller_name' => 'OrderController',
         
           
        ]);
    }
}
