# Audit et évolution d'une application PHP

Compte rendu des modifications effectuées lors de la première phase de reprise du projet. L'objectif était d'auditer l'existant, de corriger les problèmes structurels et de sécuriser l'application tout en conservant le paradigme procédural actuel, sans régression fonctionnelle.

---

## 1. Constats initiaux

Lors de l'exploration de la base de code d'origine, plusieurs points bloquants pour la maintenabilité et le travail en équipe ont été identifiés :

* **Absence de séparation des responsabilités** : Les fichiers de vues (`index.php`, `book.php`, `author.php`) mélangeaient HTML, connexion à la base de données, requêtes SQL et logique métier.
* **Duplication de code** : L'en-tête (`header`), le pied de page (`footer`) et la connexion à la base de données étaient répétés dans plusieurs fichiers.
* **Arborescence plate et désordonnée** : Les fichiers de base de données, les scripts de traitement (`delete-book.php`) et les vues se trouvaient au même niveau. Un fichier de base de données parasite (`source-etudiantdatabase.sqlite`) traînait également à la racine.
* **Chemins relatifs fragiles** : Les inclusions et l'accès à la base de données reposaient sur des chemins relatifs susceptibles de casser lors de tout déplacement de fichier.
* **Manque de gestion d'erreurs** : Aucune vérification d'existence ni erreur `404` n'était prévue pour les identifiants invalides (livres, auteurs ou suppressions).
* **Gestion Git incomplète** : Absence de fichier `.gitignore`, entraînant le suivi de la base de données locale SQLite.

---

## 2. Évolution de l'arborescence

### Avant (Arborescence de base)
```text
│   LA MANU_TP_POO Avancée.pdf
│   source-etudiantdatabase.sqlite
│   
└───source-etudiant
    │   author.php
    │   book.php
    │   database.sqlite
    │   delete-book.php
    │   index.php
    │   library.sql
    │   
    └───assets
        ├───css
        │       style.css
        │       style.css.map
        │       style.scss
        │       
        └───img
                open-book.svg
```

### Après (Arborescence actuelle)
```text
│   .gitignore
│   LA MANU_TP_POO Avancée.pdf
│   README.md
│   
└───source-etudiant
    │   author.php
    │   book.php
    │   index.php
    │   
    ├───assets
    │   ├───img
    │   │       open-book.svg
    │   │       
    │   ├───js
    │   │       script.js
    │   │       
    │   └───style
    │       ├───css
    │       │       style.css
    │       │       style.css.map
    │       │       
    │       └───scss
    │               style.scss
    │               
    ├───config
    │       constants.php
    │       
    ├───database
    │   │   database.sqlite
    │   │   library.sql
    │   │   
    │   └───queries
    │           queries.php
    │           
    ├───helpers
    │       db_connect.php
    │       
    ├───partials
    │       footer.php
    │       header.php
    │       
    └───utils
            delete-book.php
```

---

## 3. Détail des améliorations apportées

### Architecture et configuration
* **Centralisation des constantes (`config/constants.php`)** : Création d'un dossier `config` et définition de la constante `DOCUMENT_ROOT`. Son utilisation dans les fichiers et dans la connexion à la base de données garantit des chemins absolus fiables.
* **Réorganisation des assets (`assets/`)** :
  * Séparation des fichiers de style dans `assets/style/css/` et `assets/style/scss/`.
  * Création d'un dossier `assets/js/` contenant `script.js`, avec correction du lien d'appel dans le header.
* **Isolation des traitements (`utils/`)** : Déplacement de `delete-book.php` dans un dossier `utils/` dédié, avec mise à jour des liens et des redirections pour assurer le bon fonctionnement de la suppression.
* **Gestion Git et propreté du dépôt** : Ajout d'un `.gitignore` (excluant notamment les fichiers `.sqlite`), suppression du fichier parasite `source-etudiantdatabase.sqlite` à la racine et correction de la structure globale du dépôt.

### Base de données et requêtes SQL
* **Regroupement des fichiers BDD (`database/`)** : Déplacement de `database.sqlite` et `library.sql` dans un dossier dédié.
* **Connexion centralisée (`helpers/db_connect.php`)** : Extraction et correction de la connexion SQLite dans un fichier helper unique, utilisant `DOCUMENT_ROOT`.
* **Centralisation des requêtes (`database/queries/queries.php`)** : Regroupement de l'ensemble des requêtes SQL dans un fichier dédié, puis adaptation des pages pour appeler ces requêtes au lieu de les écrire en dur.

### Modularité des vues (Partials)
* **Factorisation du HTML (`partials/header.php` et `partials/footer.php`)** : Découpage des éléments communs et intégration via `include` sur l'ensemble des pages (`index.php`, `book.php`, `author.php`).
* **Titres dynamiques** : Mise en place et correction de l'affichage dynamique du titre de chaque page, avec ajustement de l'ordre d'appel du header.

### Fiabilité, gestion d'erreurs et UX
* **Gestion des erreurs 404** : Ajout de vérifications et de réponses `404` dans `book.php`, `author.php` (contrôle de l'ID auteur) et `delete-book.php`.
* **Sécurisation de la suppression** : Ajout d'une vérification de l'existence du livre en base avant de procéder à sa suppression dans `delete-book.php`.
* **Tri des données** : Mise en place d'un affichage par ordre alphabétique.

### Assainissement du code (Cleanup)
* Nettoyage et refactorisation des fichiers principaux : `index.php`, `book.php`, `author.php` et `delete-book.php`.