# FitManager - Systeme de Gestion de Salle de Sport

## Description
FitManager est une application web de gestion de salle de sport permettant aux utilisateurs de gerer leurs cours et equipements de maniere simple et efficace.

## Fonctionnalites

### Authentification
- Inscription avec nom, email et mot de passe
- Connexion securisee
- Deconnexion
- Sessions utilisateurs

### Dashboard
- Affichage du nombre total de cours
- Affichage du nombre total d'equipements
- Visualisation de la repartition des cours par categorie
- Visualisation de la repartition des equipements par type 

### Gestion des Cours
- Ajouter un cours (nom, categorie, date, heure, duree, max participants)
- Modifier un cours existant
- Supprimer un cours
- Lister tous les cours de l'utilisateur

### Gestion des Equipements
- Ajouter un equipement (nom, type, quantite, etat)
- Modifier un equipement existant
- Supprimer un equipement
- Lister tous les equipements de l'utilisateur

## Technologies Utilisees

- **Backend**: PHP 
- **Base de donnees**: MySQL
- **Frontend**: HTML5, CSS3
- **Serveur local**: XAMPP
- **Architecture**: MVC simplifie

## Structure du Projet

```
FitManager/
├── assets/
│   └── style.css
├── config/
│   └── config.php
├── includes/
│   ├── header.php
│   └── footer.php
├── auth/
│   ├── login.php
│   ├── register.php
│   └── logout.php
├── database.sql
├── index.php
├── cours.php
├── cours_add.php
├── cours_edit.php
├── cours_delete.php
├── equipements.php
├── equipements_add.php
├── equipements_edit.php
└── equipements_delete.php
```

### Prerequisites
- XAMPP (Apache + MySQL + PHP)
- Navigateur web moderne
