// ----------------------------------  MODIFIER LE COMPORTEMENT DU BOUTON SUBMIT DU FORMULAIRE  ---------------------------------------

// On souhaite que tout les acteurs, producteurs, réalisateurs soient sélectionnés automatiquement AVANT la soumission du formulaire.
var formulaire = document.getElementById("movieForm");
var submitButton = document.getElementById("send_button");

// Ajout d'un gestionnaire d'événement pour l'événement 'submit'
formulaire.addEventListener("submit", function (event) {
  event.preventDefault(); // Empêche le formulaire d'être soumis de manière traditionnelle
  selectActorsDirectorsProducers(); // Appelle la fonction définie plus haut  // CETTE FONCTION CE TROUVE BIEN PLUS BAS DANS LE CODE
  submitButton.disabled = true;
  formulaire.submit(); //On soumet ensuite le formulaire
});

// ----------------------------------  LES IMAGES  ---------------------------------------

// pour afficher les images, cette fonction est appellée par la fonction fetchMovieData juste au dessus.
// elle prend en paramètre l'id de la balise image "preview", l'id de l'input pour y mettre le lien, et le chemin de l'image du fichier json
function setImagePreview(imagePreviewElementId, imagePathInputId, imagePath) {
  const baseUrl = "https://image.tmdb.org/t/p/w342";
  if (imagePath) {
    const fullUrl = baseUrl + imagePath;
    document.getElementById(imagePreviewElementId).src = fullUrl; // Défini l'attribut src de l'élément image
    document.getElementById(imagePathInputId).value = fullUrl; // Défini la valeur du champ de saisie
  }
}

// ----------------------------------RECUPERER LE RESUME EN ANGLAIS---------------------------------------

// document
//   .getElementById("fetchOverviewFromEnglish")
//   .addEventListener("click", fetchOverviewFromEnglish);

// function fetchOverviewFromEnglish() {
//   const movieId = document.getElementById("movieId").value;
//   const apiKey = "efd61fb3993629984089f6f24d83f7c6";
//   const url_en = `http://api.themoviedb.org/3/movie/${movieId}?api_key=${apiKey}&language=en-EN`;

//   fetch(url_en)
//     .then((response) => response.json())
//     .then((data) => {
//       if (data.overview) {
//         document.getElementById("movie_overview").value = data.overview;
//       } else {
//         alert("Aucun aperçu anglais disponible pour ce film.");
//       }
//     })
//     .catch((error) => console.error("Erreur:", error));
// }

// ----------------------------------TRADUIRE LE SYNOPSYS EN ANGLAIS---------------------------------------
function translateOverview() {
  const overview = document.getElementById("movie_overview").value;
  const googleTranslateApiKey = "votre_clé_api_google_translate";
  const targetLanguage = "fr";

  fetch(
    `https://translation.googleapis.com/language/translate/v2?key=${googleTranslateApiKey}`,
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        q: overview,
        target: targetLanguage,
      }),
    }
  )
    .then((response) => response.json())
    .then((data) => {
      if (
        data &&
        data.data &&
        data.data.translations &&
        data.data.translations[0]
      ) {
        const translatedText = data.data.translations[0].translatedText;
        document.getElementById("movie_overview").value = translatedText;
      } else {
        alert("Impossible de traduire l'aperçu.");
      }
    })
    .catch((error) => console.error("Erreur:", error));
}

// ----------------------------------  CHARGER MANUELLEMENT LES IMAGES DANS LES PREVIEWS  ---------------------------------------
document
  .getElementById("loadNewImage_movie_poster_path")
  .addEventListener("click", function () {
    loadNewImage("movie_poster_path", "movie_poster_preview");
  });

document
  .getElementById("loadNewImage_movie_backdrop_path")
  .addEventListener("click", function () {
    loadNewImage("backdrop_path", "backdrop_path_preview");
  });

document
  .getElementById("loadNewImage_collection_poster_path")
  .addEventListener("click", function () {
    loadNewImage("collection_poster_path", "collection_poster_path_preview");
  });

document
  .getElementById("loadNewImage_collection_backdrop_path")
  .addEventListener("click", function () {
    loadNewImage(
      "collection_backdrop_path",
      "collection_backdrop_path_preview"
    );
  });

function loadNewImage(inputId, previewId) {
  const imageUrl = document.getElementById(inputId).value;
  if (imageUrl) {
    const previewElement = document.getElementById(previewId);
    previewElement.src = imageUrl;
  } else {
    alert("Veuillez saisir un lien d'image valide.");
  }
}


// ---------------------------------- AJOUTER OU SUPPRIMER UN ACTEUR ---------------------------------------

document
  .getElementById("deleteActor")
  .addEventListener("click", supprimerActeur);
document.getElementById("addActor").addEventListener("click", ajouterActeur);

document
  .getElementById("deleteDirector")
  .addEventListener("click", supprimerRealisateur);
document
  .getElementById("addDirector")
  .addEventListener("click", ajouterRealisateur);

document
  .getElementById("deleteProducer")
  .addEventListener("click", supprimerProducteur);
document
  .getElementById("addProducer")
  .addEventListener("click", ajouterProducteur);
// Liste des acteurs
let acteurs = [];

// Sélectionnez la liste déroulante des acteurs
const selectorActors = document.getElementById("actor-selector");

// Fonction pour ajouter un acteur
function ajouterActeur() {
  // Obtenez le nom de l'acteur à partir du champ de saisie
  const newActor = document.getElementById("new-actor").value.trim();

  // Vérifiez si le nom de l'acteur n'est pas vide et s'il n'existe pas déjà
  if (newActor !== "" && !acteurs.includes(newActor)) {
    // Ajoutez le nouvel acteur à la liste
    acteurs.push(newActor);

    // Ajoutez le nouvel acteur comme une nouvelle option à la liste déroulante
    const option = document.createElement("option");
    option.text = newActor;
    selectorActors.add(option);

    // Effacez le champ de saisie
    document.getElementById("new-actor").value = "";
  }
}

// Fonction pour supprimer un acteur
function supprimerActeur() {
  // Sélectionnez l'indice de l'option sélectionnée dans la liste déroulante
  const selectedIndex = selectorActors.selectedIndex;

  // Vérifiez si une option est sélectionnée
  if (selectedIndex !== -1) {
    // Supprimez l'acteur de la liste des acteurs
    acteurs.splice(selectedIndex, 1);

    // Supprimez l'option sélectionnée de la liste déroulante
    selectorActors.remove(selectedIndex);
  }
}
// Liste des réalisateurs
let realisateurs = [];

// Sélectionnez la liste déroulante des réalisateurs
const directorsSelector = document.getElementById("directors-selector");

// Fonction pour ajouter un réalisateur
function ajouterRealisateur() {
  // Obtenez le nom du réalisateur à partir du champ de saisie
  const newDirector = document.getElementById("new-directors").value.trim();

  // Vérifiez si le nom du réalisateur n'est pas vide et s'il n'existe pas déjà
  if (newDirector !== "" && !realisateurs.includes(newDirector)) {
    // Ajoutez le nouveau réalisateur à la liste
    realisateurs.push(newDirector);

    // Ajoutez le nouveau réalisateur comme une nouvelle option à la liste déroulante
    const option = document.createElement("option");
    option.text = newDirector;
    directorsSelector.add(option);

    // Effacez le champ de saisie
    document.getElementById("new-directors").value = "";
  }
}

// Fonction pour supprimer un réalisateur
function supprimerRealisateur() {
  // Sélectionnez l'indice de l'option sélectionnée dans la liste déroulante
  const selectedIndex = directorsSelector.selectedIndex;

  // Vérifiez si une option est sélectionnée
  if (selectedIndex !== -1) {
    // Supprimez le réalisateur de la liste des réalisateurs
    realisateurs.splice(selectedIndex, 1);

    // Supprimez l'option sélectionnée de la liste déroulante
    directorsSelector.remove(selectedIndex);
  }
}

// Liste des producteurs
let producteurs = [];

// Sélectionnez la liste déroulante des producteurs
const producerSelector = document.getElementById("producer-selector");

// Fonction pour ajouter un producteur
function ajouterProducteur() {
  // Obtenez le nom du producteur à partir du champ de saisie
  const newProducer = document.getElementById("new-producer").value.trim();

  // Vérifiez si le nom du producteur n'est pas vide et s'il n'existe pas déjà
  if (newProducer !== "" && !producteurs.includes(newProducer)) {
    // Ajoutez le nouveau producteur à la liste
    producteurs.push(newProducer);

    // Ajoutez le nouveau producteur comme une nouvelle option à la liste déroulante
    const option = document.createElement("option");
    option.text = newProducer;
    producerSelector.add(option);

    // Effacez le champ de saisie
    document.getElementById("new-producer").value = "";
  }
}

// Fonction pour supprimer un producteur
function supprimerProducteur() {
  // Sélectionnez l'indice de l'option sélectionnée dans la liste déroulante
  const selectedIndex = producerSelector.selectedIndex;

  // Vérifiez si une option est sélectionnée
  if (selectedIndex !== -1) {
    // Supprimez le producteur de la liste des producteurs
    producteurs.splice(selectedIndex, 1);

    // Supprimez l'option sélectionnée de la liste déroulante
    producerSelector.remove(selectedIndex);
  }
}

// ---------------------------------- SELECTIONNER TOUS LES ACTEURS, REALISATEURS ET PRODUCTEURS ---------------------------------------

function selectActorsDirectorsProducers() {
  var select = document.getElementById("actor-selector");
  var options = select.options;
  for (var i = 0; i < options.length; i++) {
    options[i].selected = true;
  }

  var select = document.getElementById("directors-selector");
  var options = select.options;
  for (var i = 0; i < options.length; i++) {
    options[i].selected = true;
  }

  var select = document.getElementById("producer-selector");
  var options = select.options;
  for (var i = 0; i < options.length; i++) {
    options[i].selected = true;
  }
}

// ----------------------------------  AUTO-SLUG ---------------------------------------
document.getElementById("movie_title").addEventListener("input", function () {
  let theSlug = string_to_slug(this.value);
  document.getElementById("slug").value = theSlug;
});

function string_to_slug(str) {
  str = str.replace(/^\s+|\s+$/g, ""); // trim
  str = str.toLowerCase();
  str = str.replace(/œ/g, "oe");

  // remove accents, swap ñ for n, etc
  var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
  var to = "aaaaeeeeiiiioooouuuunc------";
  for (var i = 0, l = from.length; i < l; i++) {
    str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
  }

  str = str
    .replace(/[^a-z0-9 -]/g, "") // remove invalid chars
    .replace(/\s+/g, "-") // collapse whitespace and replace by -
    .replace(/-+/g, "-"); // collapse dashes

  return str;
}




































