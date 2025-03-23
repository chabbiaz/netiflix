// Définir le focus sur l'élément input
// document.getElementById("movieId").focus();

document
  .getElementById("fetchMovieData")
  .addEventListener("click", fetchMovieData);

function fetchMovieData() {
  const movieId = document.getElementById("movieId").value;

  // récupérer l'ID du film saisi.
  // S'il n'y a pas d'ID de film fourni, une alerte est affichée, et la fonction s'arrête.
  if (!movieId) {
    alert("Veuillez entrer l'ID d'un film.");
    return;
  }

  // clé de l'API
  const apiKey = "VOTRE_CLE_API_TMDB";
  //info du film
  const url = `http://api.themoviedb.org/3/movie/${movieId}?api_key=${apiKey}&language=fr-FR`;
  //info des acteurs
  const urlCredits = `https://api.themoviedb.org/3/movie/${movieId}/credits?api_key=${apiKey}&language=fr-FR`;
  //info des trailers
  const url_trailer = `https://api.themoviedb.org/3/movie/${movieId}/videos?api_key=${apiKey}&language=fr-FR`;

  // récupérer les données du film
  fetch(url)
    .then((response) => response.json()) // attendre la réponse, et convertir la réponse en JSON
    .then((data) => {
      // Réinitialiser les cases à cocher pour les genres
      document.querySelectorAll('input[name="genre"]').forEach((checkbox) => {
        checkbox.checked = false;
      });

      // Définir la case a cocher film adulte ou non
      document.getElementById("adult_true").checked = data.adult;
      document.getElementById("adult_false").checked = !data.adult;

      // on appel la fonction setImagePreview pour afficher les images
      // elle prend en paramètre l'id de l'élément image html, l'id de l'input pour y mettre le lien, et le chemin de l'image du fichier json
      setImagePreview(
        "backdrop_path_preview",
        "backdrop_path",
        data.backdrop_path
      );

      // si le film appartient à une collection, on fait appel à la fonction setImagePreview pour afficher les images
      if (data.belongs_to_collection) {
        document.getElementById("collection_id").value =
          data.belongs_to_collection.id;
        document.getElementById("collection_name").value =
          data.belongs_to_collection.name;
        setImagePreview(
          "collection_poster_path_preview",
          "collection_poster_path",
          data.belongs_to_collection.poster_path
        );
        setImagePreview(
          "collection_backdrop_path_preview",
          "collection_backdrop_path",
          data.belongs_to_collection.backdrop_path
        );
      }

      // Définir les valeurs des champs
      document.getElementById("adult_true").checked = data.adult;
      document.getElementById("adult_false").checked = !data.adult;
      document.getElementById("movie_id").value = data.id || "";
      document.getElementById("movie_imdb_id").value = data.imdb_id || "";
      document.getElementById("movie_original_language").value =
        data.original_language || "";
      document.getElementById("movie_original_title").value =
        data.original_title || "";
      document.getElementById("movie_overview").value = data.overview || "";
      document.getElementById("movie_release_date").value =
        data.release_date || "";
      document.getElementById("movie_runtime").value = data.runtime || "";
      document.getElementById("movie_title").value = data.title || "";
      document.getElementById("movie_vote_count").value = data.vote_count || "";

      // rechercher manullement le lien youtube
      const youtubeSearchLink = document.createElement("a"); // on crée une balise <a>
      youtubeSearchLink.href = `https://www.youtube.com/results?search_query=${data.original_title}+trailer`; // on définit l'attribut href de la balise <a>
      youtubeSearchLink.target = "_blank"; // on définit l'attribut target de la balise <a>
      youtubeSearchLink.textContent = "Rechercher manuellement le trailer"; // on définit le texte de la balise <a>
      document.getElementById("search_trailer").appendChild(youtubeSearchLink);
      // sélectionne un élément existant dans le document HTML qui a l'ID "search_trailer"
      // et on définit son attribut href avec l'URL de recherche YouTube précédemment construite.

      // ouvrir le lien de l'affiche imdb
      const imdbSearchLink = document.createElement("a"); // on crée une balise <a> qu'on va ajouter à la page
      imdbSearchLink.href = `https://www.imdb.com/title/${data.imdb_id}`; // on définit l'attribut href de la balise <a>
      imdbSearchLink.target = "_blank"; // on définit l'attribut target de la balise <a>
      imdbSearchLink.textContent = "ouvrir l'affiche"; // on définit le texte de la balise <a>
      document.getElementById("search_imdb").appendChild(imdbSearchLink);
      // sélectionne un élément existant dans le document HTML qui a l'ID "search_trailer"
      // et on définit son attribut href avec l'URL de recherche YouTube précédemment construite.

      // Arrondir et définir la valeur de vote_average avec un seul chiffre après la virgule
      const voteAverage = data.vote_average ? data.vote_average.toFixed(1) : "";
      document.getElementById("movie_vote_average").value = voteAverage || "";

      // Gestion de l'affichage et du téléchargement des images
      if (data.poster_path) {
        const posterUrl = `https://image.tmdb.org/t/p/w342${data.poster_path}`;
        document.getElementById("movie_poster_path").value = posterUrl;
        document.getElementById("movie_poster_preview").src = posterUrl;
      } else {
        document.getElementById("movie_poster_path").value = "";
        document.getElementById("movie_poster_preview").src = "";
      }

      // Gestion des genres
      if (data.genres && data.genres.length > 0) {
        data.genres.forEach((genre) => {
          const genreCheckbox = document.getElementById(`genre_${genre.id}`);
          if (genreCheckbox) genreCheckbox.checked = true;
        });
      }
    });

  // récupérer les trailers
  fetch(url_trailer)
    .then((response) => response.json())
    .then((data) => {
      const trailersFieldset = document.getElementById("trailers");
      trailersFieldset.innerHTML = ""; // Effacer le contenu précédent

      if (data.results && data.results.length > 0) {
        data.results.forEach((trailer) => {
          const label = document.createElement("label");
          label.textContent = `${trailer.site} - ${trailer.type} - ${trailer.name}`;

          const radioButton = document.createElement("input");
          radioButton.type = "radio";
          radioButton.name = "selectedTrailer";
          radioButton.value = `${trailer.key}`;
          radioButton.addEventListener("change", function () {
            document.getElementById("movie_trailer").value = radioButton.value;
          });

          label.appendChild(radioButton);
          trailersFieldset.appendChild(label);
          trailersFieldset.appendChild(document.createElement("br"));
        });
      } else {
        trailersFieldset.textContent = "Aucun trailer disponible sur tmdb. ";
      }
    });

  /// récupérer les acteurs, réalisateurs et producteurs
  fetch(urlCredits)
    .then((response) => response.json())
    .then((data) => {
      // Vérifier si la liste des acteurs existe et n'est pas vide
      if (data.cast && data.cast.length > 0) {
        // Récupérer les noms des acteurs et les ajouter à la liste d'acteurs
        data.cast.forEach((actor) => {
          // Ajouter chaque acteur à la liste
          acteurs.push(actor.name);

          // Créer une nouvelle option pour l'acteur et l'ajouter à la liste déroulante
          const option = document.createElement("option");
          option.text = actor.name;
          selectorActors.add(option);
        });
      } else {
        // Afficher un message si aucun acteur n'est trouvé dans le fichier JSON
        console.log("Aucun acteur trouvé dans le fichier JSON.");
      }

      // Récupérer les réalisateurs depuis la réponse JSON
      const directors = data.crew.filter((member) => member.job === "Director");

      // Vérifier si la liste des réalisateurs n'est pas vide
      if (directors.length > 0) {
        // Parcourir la liste des réalisateurs
        directors.forEach((director) => {
          // Ajouter chaque réalisateur à la liste
          const directorName = director.name;
          // Créer une nouvelle option pour le réalisateur et l'ajouter à la liste déroulante
          const option = document.createElement("option");
          option.text = directorName;
          directorsSelector.add(option);
        });
      } else {
        // Afficher un message si aucun réalisateur n'est trouvé dans le fichier JSON
        console.log("Aucun réalisateur trouvé dans le fichier JSON.");
      }

      // Récupérer les producteurs depuis la réponse JSON
      const producers = data.crew.filter((member) => member.job === "Producer");

      // Vérifier si la liste des producteurs n'est pas vide
      if (producers.length > 0) {
        // Parcourir la liste des producteurs
        producers.forEach((producer) => {
          // Ajouter chaque producteur à la liste
          const producerName = producer.name;
          // Créer une nouvelle option pour le producteur et l'ajouter à la liste déroulante
          const option = document.createElement("option");
          option.text = producerName;
          producerSelector.add(option);
        });
      } else {
        // Afficher un message si aucun producteur n'est trouvé dans le fichier JSON
        console.log("Aucun producteur trouvé dans le fichier JSON.");
      }

      // Générer le slug
      function generateSlug() {
        let titleInput = document.getElementById("movie_title");
        let slugInput = document.getElementById("slug");
        let theSlug = string_to_slug(titleInput.value);
        slugInput.value = theSlug;
      }

      generateSlug();
    })
    .catch((error) => console.error("Erreur:", error));
}

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

document
  .getElementById("fetchOverviewFromEnglish")
  .addEventListener("click", fetchOverviewFromEnglish);

function fetchOverviewFromEnglish() {
  const movieId = document.getElementById("movieId").value;
  const apiKey = "efd61fb3993629984089f6f24d83f7c6";
  const url_en = `http://api.themoviedb.org/3/movie/${movieId}?api_key=${apiKey}&language=en-EN`;

  fetch(url_en)
    .then((response) => response.json())
    .then((data) => {
      if (data.overview) {
        document.getElementById("movie_overview").value = data.overview;
      } else {
        alert("Aucun aperçu anglais disponible pour ce film.");
      }
    })
    .catch((error) => console.error("Erreur:", error));
}

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

// ----------------------------------EFFACER TOUS LES CHAMPS---------------------------------------

document.getElementById("resetFields").addEventListener("click", resetFields);

function resetFields() {
  document
    .querySelectorAll(
      'input[type="text"], input[type="date"], input[type="number"], input[type="checkbox"], textarea'
    )
    .forEach((field) => {
      field.value = ""; // Réinitialiser la valeur des champs
    });
  document.querySelectorAll("a").forEach((link) => {
    link.remove();
  });
  document.querySelectorAll(".selector").forEach((select) => {
    select.options.length = 0;
  }); // Réinitialiser les options des listes déroulantes

  document
    .querySelectorAll('.item-checkbox input[type="checkbox"]')
    .forEach((checkbox) => {
      checkbox.checked = false;
    }); // Décochez la case à cocher
  const trailersFieldset = document.getElementById("trailers");
  trailersFieldset.querySelectorAll("label").forEach((label) => {
    trailersFieldset.removeChild(label);
  });
  document.querySelectorAll("img").forEach((image) => {
    image.removeAttribute("src");
  });
}

// ---------------------------------- AJOUTER OU SUPPRIMER UN ACTEUR ---------------------------------------

document.getElementById("deleteActor").addEventListener("click", supprimerActeur);
document.getElementById("addActor").addEventListener("click", ajouterActeur);
document.getElementById("deleteDirector").addEventListener("click", supprimerRealisateur);
document.getElementById("addDirector").addEventListener("click", ajouterRealisateur);
document.getElementById("deleteProducer").addEventListener("click", supprimerProducteur);
document.getElementById("addProducer").addEventListener("click", ajouterProducteur);

// Liste des acteurs
let acteurs = [];
const selectorActors = document.getElementById("actor-selector");

function ajouterActeur() {
  const newActors = document.getElementById("new-actor").value.trim();
  const newActorsArray = newActors.split("\n").map(actor => actor.trim()).filter(actor => actor !== "");

  newActorsArray.forEach(actor => {
    if (!acteurs.includes(actor)) {
      acteurs.push(actor);
      const option = document.createElement("option");
      option.text = actor;
      selectorActors.add(option);
    }
  });

  document.getElementById("new-actor").value = "";
}

function supprimerActeur() {
  const selectedIndex = selectorActors.selectedIndex;
  if (selectedIndex !== -1) {
    acteurs.splice(selectedIndex, 1);
    selectorActors.remove(selectedIndex);
  }
}

// Liste des réalisateurs
let realisateurs = [];
const directorsSelector = document.getElementById("directors-selector");

function ajouterRealisateur() {
  const newDirectors = document.getElementById("new-directors").value.trim();
  const newDirectorsArray = newDirectors.split("\n").map(director => director.trim()).filter(director => director !== "");

  newDirectorsArray.forEach(director => {
    if (!realisateurs.includes(director)) {
      realisateurs.push(director);
      const option = document.createElement("option");
      option.text = director;
      directorsSelector.add(option);
    }
  });

  document.getElementById("new-directors").value = "";
}

function supprimerRealisateur() {
  const selectedIndex = directorsSelector.selectedIndex;
  if (selectedIndex !== -1) {
    realisateurs.splice(selectedIndex, 1);
    directorsSelector.remove(selectedIndex);
  }
}

// Liste des producteurs
let producteurs = [];
const producerSelector = document.getElementById("producer-selector");

function ajouterProducteur() {
  const newProducers = document.getElementById("new-producer").value.trim();
  const newProducersArray = newProducers.split("\n").map(producer => producer.trim()).filter(producer => producer !== "");

  newProducersArray.forEach(producer => {
    if (!producteurs.includes(producer)) {
      producteurs.push(producer);
      const option = document.createElement("option");
      option.text = producer;
      producerSelector.add(option);
    }
  });

  document.getElementById("new-producer").value = "";
}

function supprimerProducteur() {
  const selectedIndex = producerSelector.selectedIndex;
  if (selectedIndex !== -1) {
    producteurs.splice(selectedIndex, 1);
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

// ----------------------------------  AJOUTER DES BOUTONS SYMBOLES ---------------------------------------

document.getElementById("addCross").addEventListener("click", function () {
  let titleInput = document.getElementById("movie_title");
  titleInput.value += " ❌"; // Ajouter le symbole "❌" à la fin du champ movie_title
  generateSlug(); // Regénérer le slug
});

document.getElementById("addCheck").addEventListener("click", function () {
  let titleInput = document.getElementById("movie_title");
  titleInput.value += " ✅"; // Ajouter le symbole "✅" à la fin du champ movie_title
  generateSlug(); // Regénérer le slug
});

document
  .getElementById("translateButton")
  .addEventListener("click", function () {
    // Récupérer le contenu du textarea
    let overviewText = document.getElementById("movie_overview").value;

    // Construire l'URL avec le texte à traduire
    let translateURL =
      "https://translate.google.fr/?hl=fr&sl=en&tl=fr&text=" +
      encodeURIComponent(overviewText);

    // Ouvrir le lien dans un nouvel onglet
    window.open(translateURL, "_blank");
  });

//----------------------------------  REMPLACER LE TEXTE COPIER ---------------------------------------

document
  .getElementById("copyPasteButton")
  .addEventListener("click", function () {
    // Effacer le contenu actuel du textarea
    document.getElementById("movie_overview").value = "";

    // Coller le texte copié dans le textarea
    navigator.clipboard
      .readText()
      .then(function (copiedText) {
        document.getElementById("movie_overview").value = copiedText;
      })
      .catch(function (error) {
        console.error("Erreur lors de la lecture du texte copié: ", error);
      });
  });