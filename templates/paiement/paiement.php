if(isset($_POST['prix']) && !empty($_POST['prix'])){
    // Nous appelons l'autoloader pour avoir accès à Stripe
    require_once('vendor/autoload.php');

    // Nous instancions Stripe en indiquand la clé privée, pour prouver que nous sommes bien à l'origine de cette demande
    \Stripe\Stripe::setApiKey('sk_test_51L9XNOK2P3uJ8QLpAodNXhp4SHwwKZtJ2QroeCvFEGNiRTSWwm9radVPjGStUXlE0SgPLTkjue5UJRj96qknDMW400StYb9DvZ');

    // Nous créons l'intention de paiement et stockons la réponse dans la variable $intent
    $intent = \Stripe\PaymentIntent::create([
        'amount' => $_POST['prix']*100, // Le prix doit être transmis en centimes
        'currency' => 'eur',
    ]);
}
{% extends 'base.html.twig' %}

{% block title %}paiement Cotisation{% endblock %}

{% block body %}
  {% include('inc/slides.html.twig') %}<br/>
<section class="container"><div class="row"><div class="col">
  <h4>Get in touch with us by filling <strong>contact form below</strong></h4>
<form method="post">
    <div id="errors"></div>
    <input id="cardholder-name" type="text" placeholder="Titulaire de la carte">
    <div id="card-element">
    </div>
    <div id="card-errors" role="alert"></div>
    <button id="card-button" type="button" data-secret="<?= $intent['client_secret'] ?>">Valider le paiement</button>
</form>
</div>
</div>
</section>
<script src="js/scripts.js"></script>
<script src="https://js.stripe.com/v3/"></script>
 <script src="js/scripts_paiement.js"></script>
{% endblock %}
