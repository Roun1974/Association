window.onload = () => {
// On instancie Stripe et on lui passe notre clé publique
let stripe = Stripe('pk_test_51L9XNOK2P3uJ8QLpYE2CRDI5D5piBS49I2RNGMasnMlPBXKNGg9lWeCqrtggK3KmH516itxsuPW6j0IBHGkFlKsX00GgnbWdKf');

// Initialise les éléments du formulaire
let elements = stripe.elements();

// Définit la redirection en cas de succès du paiement
let redirect = "main_accueil";

// Récupère l'élément qui contiendra le nom du titulaire de la carte
let cardholderName = document.getElementById('cardholder-name');

// Récupère l'élement button
let cardButton = document.getElementById('card-button');

// Récupère l'attribut data-secret du bouton
let clientSecret = cardButton.dataset.secret;

// Crée les éléments de carte et les stocke dans la variable card
let card = elements.create("card");
card.mount("#card-element");
card.addEventListener('change', function(event) {
  // On récupère l'élément qui permet d'afficher les erreurs de saisie
  let displayError = document.getElementById('card-errors');

  // Si il y a une erreur
  if (event.error) {
      // On l'affiche
      displayError.textContent = event.error.message;
  } else {
      // Sinon on l'efface
      displayError.textContent = '';
  }
});
cardButton.addEventListener('click', () => {
  // On envoie la promesse contenant le code de l'intention, l'objet "card" contenant les informations de carte et le nom du client
  stripe.handleCardPayment(
      clientSecret, card, {
          payment_method_data: {
              billing_details: {name: cardholderName.value}
          }
      }
  ).then(function(result) {
      // Quand on reçoit une réponse
      if (result.error) {
          // Si on a une erreur, on l'affiche
          document.getElementById("errors").innerText = result.error.message;
      } else {
          // Sinon on redirige l'utilisateur
          document.location.href = redirect;
      }
  });
});
}