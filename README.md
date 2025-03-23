# 🎬 Netiflix — Projet de fin d'étude (juin 2024)

La réutilisation de se projet à but lucratif est strictement interdite.



LE SITE EN LIGNE:
[CLIQUEZ ICI POUR LE VOIR EN LIGNE](https://zcproduction.shop)


**Netiflix** est un projet web développé dans le cadre de notre formation, avec l’ambition de devenir la **principale plateforme en France pour la vente de DVD de films**.

Notre objectif est de **promouvoir la richesse et la diversité du cinéma**, afin de satisfaire les amateurs de tous horizons et d’éveiller la curiosité des néophytes.  
Le projet met l'accent sur une **expérience utilisateur simple, intuitive et élégante**, pour parcourir, gérer et acheter des films en DVD.

---

## 🌟 Fonctionnalités principales

- 🏠 Page d’accueil
- 🎞️ Catalogue de films avec affiches, descriptions, genres, réalisateurs
- ➕ Ajout de films (formulaire)
- ✏️ Édition et suppression de films
- 🛒 Panier et système de commande
- 🔐 Authentification & inscription utilisateur
- 📦 Gestion des adresses & commande finale
- 📬 Page de contact (envoi d'email)

---

## 🎥 Démo vidéo

👉 [Voir comment ajouter un film sur Netiflix](https://youtu.be/75KjeUcvAm8)

---

## 🛠️ Technologies utilisées

- PHP (POO & MVC)
- MySQL
- HTML / CSS
- JavaScript
- Apache (XAMPP/MAMP)
- Sessions & routage manuel

---

## 🚀 Lancer le projet en local

1. Clone le dépôt

2. Place-le dans le dossier `htdocs` de XAMPP

3. Démarre Apache + MySQL via XAMPP

4. Créer une base de donnée intitulé "netiflix" dans phpmyadmin

5. Y importer la base de données `netiflix.sql` dans **phpMyAdmin**

6. Accède à l’URL suivante :  
   [http://localhost/](http://localhost/)
   
7. Créer un compte sur le site

8. Rendre votre compte administrateur afin d'ajouter des films:

    8.1 Se rendre dans phpmyadmin, puis dans la table "clients"

    8.2 Modifier la valeur de "isAdmin" de votre compte à "1".
    
    8.3 Creer un compte sur tmdb.com et généré une clé API.
    
    8.4 Renseigner cette clé API dans public/js/addmovie.js:
        // clé de l'API
        const apiKey = "VOTRE_CLE_API_TMDB";



## 👨‍🎓 A propos

Ce projet a été réalisé dans le cadre d’un **projet de fin d’étude**, présenter en **juin 2024**.

---

## 📫 Contact

Pour toute remarque ou suggestion :  
**Auteur :** Zyad  
📧 Contact : *chabbiaz@hotmail.fr*
