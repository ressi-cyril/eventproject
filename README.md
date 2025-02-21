# Projet CodeIgniter – Présentation d’Évènement

Ce projet a pour objectif de présenter un évènement interne (thématique) se déroulant à plusieurs dates et lieux. Il s’agit d’un **site éphémère** qui peut être archivé ou dupliqué pour d’autres évènements similaires.

## 1. Fonctionnalités Principales ADMIN

- **Gestion des EVENT** 
  - CRUD
- **Gestion des EVENT OCCURRENCE associés**  
  - CRUD
- **Gestion des GALLERY**  
  - Catégorisation des photos (EVENT global ou EVENT OCCURRENCE).  
  - L’implémentation des opérations de mise à jour et de suppression pour la galerie reste à finaliser.
- **Gestion des PAGES**  
  - CRUD
- **Gestion des PAGES CONTENT associés**  
  - CRUD avec image

## 2. Architecture & Organisation

- **Framework** : CI4
- **MVC + Services** :  
  - Contrôleurs → Services → Modèles.  
  - Les Services contiennent la logique métier (ex. `EventService`), et font appels à differents service (FileService, ValidationService..).
- **Front-End** :  
  - Utilisation de Bootstrap pour la mise en page.


## 3. Installation & Lancement

todo

## 4. Avancement & Prochaines Étapes

- Le **back-office** est opérationnel (CRUD principal) : gestion complète des évènements, dates, pages et galeries (excepté la mise à jour/suppression des galeries, en cours de finalisation).
- **Prochaines étapes** :  
  - Finaliser l’édition/suppression des galeries.  
  - Ajouter l’éditeur HTML pour les blocs de contenu.  
  - Mettre en place la gestion des rôles et de l’authentification pour sécuriser le back-offic.
  - Decoupage du front (templating, header / footer ..)
  - Tout le front visiteur

---


# eventproject
