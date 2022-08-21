window.onload = () => {
    // On va chercher toutes les étoiles
    const stars = document.querySelectorAll(".la-star");
    
    // On va chercher l'input
    const note = document.querySelector("#note");

    // On boucle sur les étoiles pour le ajouter des écouteurs d'évènements
    for(star of stars){
        // On écoute le survol
        star.addEventListener("mouseover", function(){
            resetStars();
            this.style.color = "red";
            this.classList.add("las");
            this.classList.remove("lar");
            // L'élément précédent dans le DOM (de même niveau, balise soeur)
            let previousStar = this.previousElementSibling;

            while(previousStar){
                // On passe l'étoile qui précède en rouge
                previousStar.style.color = "red";
                previousStar.classList.add("las");
                previousStar.classList.remove("lar");
                // On récupère l'étoile qui la précède
                previousStar = previousStar.previousElementSibling;
            }
        });

        // On écoute le clic
        star.addEventListener("click", function(){
            note.value = this.dataset.value;
        });

        star.addEventListener("mouseout", function(){
            resetStars(note.value);
        });
    }

    /**
     * Reset des étoiles en vérifiant la note dans l'input caché
     * @param {number} note 
     */
    function resetStars(note = 0){
        for(star of stars){
            if(star.dataset.value > note){
                star.style.color = "black";
                star.classList.add("lar");
                star.classList.remove("las");
            }else{
                star.style.color = "red";
                star.classList.add("las");
                star.classList.remove("lar");
            }
        }
    }
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
}