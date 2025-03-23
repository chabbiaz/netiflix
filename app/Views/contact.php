<?php require_once './app/Views/header.php'; ?>

  <!-- si l'utilisateur n'a pas saisi tout les champs -->
  <?php
  if (isset($_SESSION['emptyForm'])) {
    echo "<p class='text-center mb-3 red rem16 pt-2'>" . htmlspecialchars($_SESSION['emptyForm']) . "</p>";
    unset($_SESSION['emptyForm']);
  }
  ?>

    <!-- si le message est bien envoyé -->
    <?php
  if (isset($_SESSION['messageSend'])) {
    echo "<p class='text-center mb-3 green rem16 pt-2'>" . htmlspecialchars($_SESSION['messageSend']) . "</p>";
    unset($_SESSION['messageSend']);
  }
  ?>

    <!-- si erreur lors de l'envoi -->
    <?php
  if (isset($_SESSION['messageNotSend'])) {
    echo "<p class='text-center mb-3 red rem16 pt-2'>" . htmlspecialchars($_SESSION['messageNotSend']) . "</p>";
    unset($_SESSION['messageNotSend']);
  }
  ?>

<div class="cgv-container ">
    <h1 class="rem16">Nous envoyer un message</h1>
    <main>
        <section class="contact-form">
            <form action="sendEmail" method="POST">
                <div class="form-group">
                    <input type="text" id="nom" name="nom" placeholder="Nom :" required>
                </div>
                <div class="form-group">
                    <input type="text" id="prenom" name="prenom" placeholder="Prénom :" required>
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Email :" required>
                </div>
                <div class="form-group">
                    <input type="text" id="subject" name="subject" placeholder="Objet :" required>
                </div>
                <div class="form-group">
                    <textarea id="message" name="message" rows="5" placeholder="Message :" required></textarea>
                </div>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                <button type="submit">Envoyer</button>
            </form>
        </section>
    </main>
</div>


<?php require_once './app/Views/footer.php'; ?>