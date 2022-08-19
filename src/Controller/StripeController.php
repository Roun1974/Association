<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request; 

class StripeController extends AbstractController
{
    /**
     * @Route("/stripe", name="app_stripe")
     */
    public function index(): Response
    {
        return $this->render('stripe/index.html.twig', [
            'controller_name' => 'StripeController',
        ]);
    }
     /**
     * @Route("/paiement", name="app_paiement")
     */
    public function paiement(Request $request): Response
    {
        if(isset($_POST['prix']) && !empty($_POST['prix'])){
            require_once('../vendor/autoload.php');
            // Nous instancions Stripe en indiquand la clé privée, pour prouver que nous sommes bien à l'origine de cette demande
            \Stripe\Stripe::setApiKey('sk_test_51L9XNOK2P3uJ8QLpAodNXhp4SHwwKZtJ2QroeCvFEGNiRTSWwm9radVPjGStUXlE0SgPLTkjue5UJRj96qknDMW400StYb9DvZ');
        
            // Nous créons l'intention de paiement et stockons la réponse dans la variable $intent
            $intent = \Stripe\PaymentIntent::create([
                'amount' => $_POST['prix']*100, // Le prix doit être transmis en centimes
                'currency' => 'eur',
            ]);
        }
        return $this->render('stripe/paiement.html.twig', [
            'controller_name' => 'StripeController',
        ]);
    }
}
