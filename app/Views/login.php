<?php require_once './app/Views/header.php'; ?>

<?php if (isset($addedOk)) {
  echo htmlspecialchars($addedOk);
} ?>

<div class="email-container">

  <!-- si l'utilisateur vient de s'inscrire on affiche le message puis on le supprimer -->
  <?php
  if (isset($_SESSION['registeredOk'])) {
    echo "<p class='text-center mb-3 green rem16'>" . htmlspecialchars($_SESSION['registeredOk']) . "</p>";
    unset($_SESSION['registeredOk']);
  }
  ?>


  <form class="login-form" method="post" action="process_login">
    <h1>Connexion</h1>

    <label for="email">email</label>
    <div class="email-div">
      <input type="email" name="email" id="email" placeholder="email" value="" />
      <span id="emailjava"></span>
    </div>

    <!-- j'affiche le message d'erreur d'email s'il existe -->
    <div class="invalid removeContent"><?php if (isset($erreurs['email'])) {
                                          echo htmlspecialchars($erreurs['email']);
                                        } ?></div>
    <br>
    <label for="motdepasse">Mot de passe</label>
    <div class="motdepasse-div">
      <div><input type="password" name="motdepasse" id="motdepasse" placeholder="Mot de passe" value="" />
      </div>
      <div class="password-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#7a7a7a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon2">
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
          <circle cx="12" cy="12" r="3"></circle>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#7a7a7a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon1">
          <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
          <line x1="1" y1="1" x2="23" y2="23"></line>
        </svg>
      </div>
    </div>

    <!-- j'affiche le message d'erreur du mot de passe s'il existe -->
    <div class="invalid removeContent"><?php if (isset($erreurs['motdepasse'])) {
                                          echo htmlspecialchars($erreurs['motdepasse']);
                                        } ?></div>

    <span class="testons" id="length-message"></span>
    <span id="uppercase-message"></span>
    <span id="lowercase-message"></span>
    <span id="number-message"></span>
    <span id="special-char-message"></span>

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
    <button type="submit">Se connecter</button>
  </form>
  <?php if (isset($erreurs['connexion'])) {
    echo htmlspecialchars($erreurs['connexion']);
    unset($erreurs['connexion']);
  } ?>
</div>
<script src="/public/js/login.js"></script>
<?php require_once './app/Views/footer.php'; ?>