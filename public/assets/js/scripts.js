var form = document.getElementById('{{ form.vars.id }}');
var errors = document.getElementById('card-errors');

var stripe = Stripe('{{ sk_test_51L9XNOK2P3uJ8QLpAodNXhp4SHwwKZtJ2QroeCvFEGNiRTSWwm9radVPjGStUXlE0SgPLTkjue5UJRj96qknDMW400StYb9DvZ }}');
var elements = stripe.elements();
var card = elements.create('card');

card.mount('#card-element');
card.addEventListener('change', function(event) {
  if (event.error) {
    errors.textContent = event.error.message;
    form.classList.add('has-error');
  } else {
    errors.textContent = '';
    form.classList.remove('has-error');
  }
});

form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(card).then(function(result) {
    if (result.error) {
      errors.textContent = result.error.message;
      form.classList.add('has-error');
    } else {
      document.getElementById('{{ form.children.token.vars.id }}').setAttribute('value', result.token.id);
      form.submit();
    }
  });
});