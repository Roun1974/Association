<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderController extends AbstractController
{
   /**
     * @Route("/checkout", name="order_checkout")
    
     */
    public function checkoutAction(Request $request): Response
    {
        $form = $this->get('form.factory')
  ->createNamedBuilder('payment-form')
  ->add('token', HiddenType::class, [
    'constraints' => [new NotBlank()],
  ])
  ->add('Valider', SubmitType::class)
  ->getForm();
 
  if ($request->isMethod('POST')) {
    $form->handleRequest($request);
 
    if ($form->isValid()) {
      // TODO: charge the card
    }
  }
 
return $this->render('order/checkout.html.twig', [
  'form' => $form->createView(),
  'stripe_public_key' => $this->getParameter('stripe_public_key'),
]);

        return $this->render('order/checkout.html.twig', [
            'controller_name' => 'OrderController',
         
           
        ]);
    }
}
