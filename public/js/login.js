    //   ----------------------------------             PAGE LOGIN          ---------------------------------------------------

    document.addEventListener('DOMContentLoaded', function() {
      var passwordDiv = document.querySelector('.motdepasse-div');
      var passwordInput = document.getElementById('motdepasse');

      // Valide le mot de passe dès que l'utilisateur clique sur la div contenant le champ (focus et click)
      var triggerValidation = function() {
        validatePassword();
        passwordInput.addEventListener('input', validatePassword);
      };

      passwordDiv.addEventListener('click', triggerValidation);
      passwordInput.addEventListener('focus', triggerValidation);

      // Une fois que l'utilisateur quitte la div (blur), arrête de valider à chaque frappe
      passwordInput.addEventListener('blur', function() {
        passwordInput.removeEventListener('input', validatePassword);
        resetPasswordMessages();
      });

      // Écoute les clics sur l'ensemble du document
      document.addEventListener('click', function(event) {
        if (!passwordDiv.contains(event.target)) {
          resetPasswordMessages();
        }
      });
    });

    function validatePassword() {
      var password = document.getElementById('motdepasse').value;
      var lengthMessage = document.getElementById('length-message');
      var uppercaseMessage = document.getElementById('uppercase-message');
      var lowercaseMessage = document.getElementById('lowercase-message');
      var numberMessage = document.getElementById('number-message');
      var specialCharMessage = document.getElementById('special-char-message');

      var upperCaseCharacters = /[A-Z]/g;
      var lowerCaseCharacters = /[a-z]/g;
      var numbers = /[0-9]/g;
      var specialCharacters = /[^a-zA-Z0-9]/g;

      if (password.length >= 8) {
        lengthMessage.innerHTML = '<span class="valid">8 caractères minimum ✅</span>';
      } else {
        lengthMessage.innerHTML = '<span class="invalid">8 caractères minimum</span>';
      }

      if (password.match(upperCaseCharacters)) {
        uppercaseMessage.innerHTML = '<span class="valid">1 majuscule ✅</span>';
      } else {
        uppercaseMessage.innerHTML = '<span class="invalid">1 majuscule</span>';
      }

      if (password.match(lowerCaseCharacters)) {
        lowercaseMessage.innerHTML = '<span class="valid">1 minuscule ✅</span>';
      } else {
        lowercaseMessage.innerHTML = '<span class="invalid">1 minuscule</span>';
      }

      if (password.match(numbers)) {
        numberMessage.innerHTML = '<span class="valid">1 chiffre ✅</span>';
      } else {
        numberMessage.innerHTML = '<span class="invalid">1 chiffre</span>';
      }

      if (password.match(specialCharacters)) {
        specialCharMessage.innerHTML = '<span class="valid">1 Caractère spécial ✅</span>';
      } else {
        specialCharMessage.innerHTML = '<span class="invalid">1 Caractère spécial</span>';
      }
    }

    // Si vous avez besoin de réinitialiser les messages de validation lorsque l'utilisateur quitte le champ
    function resetPasswordMessages() {
      document.getElementById('length-message').innerHTML = '';
      document.getElementById('uppercase-message').innerHTML = '';
      document.getElementById('lowercase-message').innerHTML = '';
      document.getElementById('number-message').innerHTML = '';
      document.getElementById('special-char-message').innerHTML = '';
    }



    // ------------------------------ Validation de l'email en javascript ----------------------------
    document.addEventListener('DOMContentLoaded', function() {
      var emailInput = document.getElementById('email');

      // Valide l'email dès que l'utilisateur clique dans le champ (focus)
      emailInput.addEventListener('focus', function() {
        validateEmail();
        emailInput.addEventListener('input', validateEmail);
      });

      // Une fois que l'utilisateur quitte le champ (blur), arrête de valider à chaque frappe
      emailInput.addEventListener('blur', function() {
        emailInput.removeEventListener('input', validateEmail);
        // Vous pourriez également vouloir nettoyer les messages de validation ici si nécessaire
        document.getElementById('emailjava').textContent = "";
      });
    });

    function validateEmail() {
      var email = document.getElementById('email').value;
      var regex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

      if (regex.test(email)) {
        document.getElementById('emailjava').textContent = "tout est ok ✅";
        
        document.getElementById('emailjava').style.color = 'green';
        
      } else {
        document.getElementById('emailjava').textContent = "email non valide ❌";
        document.getElementById('emailjava').style.color = 'red';
      }
    }





    // ------------------------------ Supprimer le contenu des messages d'erreur php lorsqu'un input est cliqué ----------------------------

    // Cette fonction est exécutée au chargement de la page
    window.onload = function() {
      // Sélectionnez tous les éléments input
      var inputs = document.querySelectorAll('input');

      // Ajoutez un écouteur d'événements pour chaque input
      inputs.forEach(function(input) {
        input.addEventListener('click', function() {
          // Lorsqu'un input est cliqué, sélectionnez tous les éléments avec la classe 'removeContent'
          var divsToRemoveContent = document.querySelectorAll('.removeContent');

          // Supprimez le contenu de chaque élément trouvé
          divsToRemoveContent.forEach(function(div) {
            div.innerHTML = '';
          });
        });
      });
    };

    // ------------------------------ Afficher le mot de passe ----------------------------
    var eye = document.querySelector('.icon1');
    var eyeOff = document.querySelector('.icon2');
    var passwordField = document.querySelector('#motdepasse');

    eye.addEventListener('click', function() {
      eye.style.display = 'none';
      eyeOff.style.display = 'block';
      passwordField.setAttribute('type', 'text');
    });

    eyeOff.addEventListener('click', function() {
      eyeOff.style.display = 'none';
      eye.style.display = 'block';
      passwordField.setAttribute('type', 'password');
    });