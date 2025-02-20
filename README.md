# Projet de Recherche de Stages

Ce projet vise à développer une application web facilitant la recherche de stages pour les étudiants en regroupant différentes offres de stage et en stockant les données des entreprises ayant déjà pris un stagiaire ou en recherchant un.

## Présentation du Projet

Les étudiants effectuent leurs recherches de stage en entreprise en activant leurs réseaux personnels et professionnels (LinkedIn, anciennes promotions, etc.) et en postulant à des offres.

Afin de rendre cette dernière étape de recherche de stage plus facile et pratique, nous avons créé un site web qui regroupe différentes offres de stage et qui permet de stocker les données des entreprises ayant déjà pris un stagiaire ou qui en recherchent un.

## Déroulement

Le projet se déroule pratiquement tout le long du bloc. Des temps projets sont prévus régulièrement, permettant d'avancer progressivement grâce aux connaissances acquises à l'issue de chaque prosit. Les livrables des prosits seront directement des fonctionnalités du projet.

### Étapes du Projet
1. **Composition des groupes de projet** : choix des méthodes de travail, définition des rôles, organisation et planification.
2. **Maquettage et frontend** : développement en HTML, CSS et JavaScript.
3. **Modélisation et base de données** : création du Modèle Conceptuel de Données (MCD) et mise en place de la base de données.
4. **Développement du backend** : utilisation de Laravel pour la gestion du serveur et de la logique de l'application.

## Livrable

Le projet se termine par une soutenance devant un jury. Cette soutenance comprend une petite présentation de 5 minutes et une démonstration technique. Le jury posera des questions pour vérifier les fonctionnalités techniques et fonctionnelles de l'application. Des questions-réponses individuelles évalueront l'implication personnelle de chaque membre du groupe.

## Cahier des Charges

L'application web doit permettre de :
- Regrouper toutes les offres de stage.
- Enregistrer les données des entreprises proposant des stages.
- Faciliter l'orientation des étudiants dans leurs recherches de stage.
- Enregistrer les offres par compétences pour permettre aux étudiants de trouver des stages en rapport avec leur profil.

## Spécifications Fonctionnelles

### Gestion des Accès
- **Authentification des utilisateurs** : permettre aux utilisateurs de se connecter et d'accéder aux fonctionnalités selon leurs rôles (Étudiant, Pilote, Administrateur).

### Gestion des Entreprises
- **Recherche et affichage d'entreprises** : recherche par nom, description, contact, etc.
- **Création, modification et suppression d'entreprises** : gestion des informations des entreprises.
- **Évaluation des entreprises** : permettre aux utilisateurs d'évaluer les entreprises proposant des stages.

### Gestion des Offres de Stage
- **Recherche et affichage des offres** : recherche par entreprise, titre, compétences, etc.
- **Création, modification et suppression des offres** : gestion des offres de stage.
- **Consultation des statistiques des offres** : dashboard pour visualiser les stages.

### Gestion des Pilotes de Promotions
- **Recherche, création, modification et suppression de comptes Pilote** : gestion des informations des pilotes.

### Gestion des Étudiants
- **Recherche, création, modification et suppression de comptes Étudiant** : gestion des informations des étudiants.
- **Consultation des statistiques d'un compte Étudiant** : suivi de la recherche de stage des étudiants.

### Gestion des Candidatures
- **Ajout et retrait d'offres à la wish-list** : gestion des offres intéressantes pour les étudiants.
- **Postulation à une offre** : soumission de candidature avec CV et lettre de motivation.
- **Affichage des offres en cours de candidature** : suivi des candidatures des étudiants.

## Installation

### Prérequis
- PHP
- Composer
- Laravel
- Apache
