# Audit et évolution d'une application PHP

Compte rendu des modifications effectuées lors de la première phase de reprise du projet. L'objectif était d'auditer l'existant, de corriger les problèmes structurels et de sécuriser l'application tout en conservant le paradigme procédural actuel, sans régression fonctionnelle.

## 1. Constats initiaux

Lors de l'exploration de la base de code d'origine, plusieurs points bloquants pour la maintenabilité et le travail en équipe ont été identifiés :

- **Absence de séparation des responsabilités** : Les fichiers de vues (`index.php`, `book.php`, `author.php`) mélangeaient HTML, connexion à la base de données, requêtes SQL et logique métier.
- **Duplication de code** : L'en-tête (`header`), le pied de page (`footer`) et la connexion à la base de données étaient répétés dans plusieurs fichiers.
- **Arborescence plate et désordonnée** : Les fichiers de base de données, les scripts de traitement (`delete-book.php`) et les vues se trouvaient au même niveau. Un fichier de base de données parasite (`source-etudiantdatabase.sqlite`) traînait également à la racine.
- **Chemins relatifs fragiles** : Les inclusions et l'accès à la base de données reposaient sur des chemins relatifs susceptibles de casser lors de tout déplacement de fichier.
- **Manque de gestion d'erreurs** : Aucune vérification d'existence ni erreur `404` n'était prévue pour les identifiants invalides (livres, auteurs ou suppressions).

## Évolution de l'arborescence

### Avant (Arborescence de base)
```text
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

### V2
```text
│   .gitignore
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
    │           │   main.scss
    │           │   
    │           ├───abstracts
    │           │       _index.scss
    │           │       _variables.scss
    │           │       
    │           ├───bases
    │           │       _index.scss
    │           │       _reset.scss
    │           │       
    │           └───layouts
    │                   _card.scss
    │                   _general.scss
    │                   _header.scss
    │                   _index.scss
    │                   _main.scss
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

## V2 - Détail des améliorations apportées

### Architecture et configuration
- **Centralisation des constantes (`config/constants.php`)** : Création d'un dossier `config` et définition de la constante `DOCUMENT_ROOT`. Son utilisation dans les fichiers et dans la connexion à la base de données garantit des chemins absolus fiables.
- **Réorganisation des assets (`assets/`)** :
  - Séparation des fichiers de style dans `assets/style/css/` et `assets/style/scss/`.
  - **Modularisation du SCSS** : Découpage de l'ancien fichier unique `style.scss` en plusieurs fichiers partiels organisés par rôle (`abstracts/`, `bases/`, `layouts/`) et regroupés dans `main.scss`, afin de simplifier la lecture, le repérage et la maintenance du style.
  - Création d'un dossier `assets/js/` contenant `script.js`, avec correction du lien d'appel dans le header.
- **Isolation des traitements (`utils/`)** : Déplacement de `delete-book.php` dans un dossier `utils/` dédié, avec mise à jour des liens et des redirections pour assurer le bon fonctionnement de la suppression.

### Base de données et requêtes SQL
- **Regroupement des fichiers BDD (`database/`)** : Déplacement de `database.sqlite` et `library.sql` dans un dossier dédié.
- **Connexion centralisée (`helpers/db_connect.php`)** : Extraction et correction de la connexion SQLite dans un fichier helper unique, utilisant `DOCUMENT_ROOT`.

### Modularité des vues (Partials)
- **Factorisation du HTML (`partials/header.php` et `partials/footer.php`)** : Découpage des éléments communs et intégration via `include` sur l'ensemble des pages (`index.php`, `book.php`, `author.php`).
- **Titres dynamiques** : Mise en place et correction de l'affichage dynamique du titre de chaque page, avec ajustement de l'ordre d'appel du header.

### Fiabilité, gestion d'erreurs et UX
- **Gestion des erreurs 404** : Ajout de vérifications et de réponses `404` dans `book.php`, `author.php` (contrôle de l'ID auteur) et `delete-book.php`.
- **Sécurisation de la suppression** : Ajout d'une vérification de l'existence du livre en base avant de procéder à sa suppression dans `delete-book.php`.

### V3
```text
│   .gitignore
│   LA MANU_TP_POO Avancée.pdf
│   README.md
│   
└───source-etudiant
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
    │           │   main.scss
    │           │   
    │           ├───abstracts
    │           │       _index.scss
    │           │       _variables.scss
    │           │       
    │           ├───bases
    │           │       _index.scss
    │           │       _reset.scss
    │           │       
    │           └───layouts
    │                   _card.scss
    │                   _general.scss
    │                   _header.scss
    │                   _index.scss
    │                   _main.scss
    │                   
    ├───config
    │       constants.php
    │       
    ├───controllers
    │       authors.php
    │       books.php
    │       
    ├───database
    │       database.sqlite
    │       library.sql
    │       
    ├───helpers
    │       db_connect.php
    │       
    ├───models
    │       author.php
    │       book.php
    │       
    ├───templates
    │   ├───authors
    │   │       author.php
    │   │       
    │   ├───books
    │   │       book.php
    │   │       home.php
    │   │       
    │   └───partials
    │           footer.php
    │           header.php
    │           
    └───utils
```

## V3 - Détail des améliorations apportées

Cette phase conserve les acquis de la V2 et fait évoluer l'application vers une architecture MVC, sans changement fonctionnel pour l'utilisateur.

### Architecture et configuration
- **Mise en place du modèle MVC** : séparation stricte des responsabilités entre les modèles (accès aux données), les contrôleurs (traitement des requêtes) et les vues (affichage). Le SQL ne se trouve plus que dans `models/`, le HTML uniquement dans `templates/`.

### V4
```text
│   .gitignore
│   index.php
│   LA MANU_TP_POO Avancée.pdf
│   README.md
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
│           │   main.scss
│           │   
│           ├───abstracts
│           │       _index.scss
│           │       _variables.scss
│           │       
│           ├───bases
│           │       _index.scss
│           │       _reset.scss
│           │       
│           └───layouts
│                   _card.scss
│                   _general.scss
│                   _header.scss
│                   _index.scss
│                   _main.scss
│                   
├───config
│       constants.php
│       
├───controllers
│       authors.php
│       books.php
│       
├───database
│       database.sqlite
│       library.sql
│       
├───helpers
│       db_connect.php
│       
├───models
│       author.php
│       book.php
│       
├───templates
│   │   default.php
│   │   
│   ├───authors
│   │       author.php
│   │       
│   └───books
│           book.php
│           home.php
│           
└───utils
        viewsUtils.php
```

## V4 - Détail des améliorations apportées

Cette phase conserve les acquis de la V3 et fait évoluer l'application vers une architecture buffer, sans changement fonctionnel pour l'utilisateur.

### Architecture et configuration
- **Mise en place du buffer** : Mise en place du buffer : création d'un dossier `utils/` afin de charger les différentes views, création d'un fichier `default.php` qui contient le header et le footer ainsi que la zone d'affichage dynamique. Enfin, utilisation de compact() dans l'appel de la fonction renderViews() dans les contrôleurs pour passer en paramètre les variables demandées.

## V5

L'arborescence reste identique à la V4 : seule l'organisation interne des modèles, des contrôleurs et des vues évolue.

## V5 - Détail des améliorations apportées

Cette phase conserve les acquis de la V3 (MVC) et de la V4 (buffer) et fait passer les modèles du paradigme procédural à la programmation orientée objet, sans changement fonctionnel pour l'utilisateur.

### Modèles orientés objet
- **Création des classes `Book` et `Author`** (`models/book.php`, `models/author.php`) : les anciennes fonctions deviennent des méthodes publiques.
- **Propriétés typées** : chaque colonne de la base est représentée par une propriété nullable (`?int $id`, `?string $title`, ...) avec `private(set)`.
- **Typage strict** : `declare(strict_types=1)` dans les deux modèles et types de retour explicites (`Book|false`, `Author|false`, `array`, `bool`).

### Hydratation des données (PDO → objets)
- **Fin des tableaux associatifs** : `fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Book::class)` et `setFetchMode(...)` + `fetch()` maintenant instances de `Book` / `Author`.
- **Retours cohérents** : `getBook()` → `Book|false`, `getAuthor()` → `Author|false`, `getListBooks()` et `getBooksAuthor()` → tableaux d'objets `Book[]`.
- **Templates adaptés** : `$book->title`, `$book->author_id`, `$author->biography` remplacent `$book['title']`, etc...