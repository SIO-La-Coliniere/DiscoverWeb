# Discover API – Plateforme de réservation de mini-stages

## 🚀 Objectif
Développer une application web sécurisée autour des mini-stages, permettant aux élèves de réserver des sessions dans leur établissement ou dans un autre, tout en offrant un espace de gestion pour les professeurs et les responsables (dont M. Mordelais).  
Le projet met l’accent sur :
- la sécurité,
- l’interopérabilité,
- la simplicité d’utilisation.

---

## 🛠️ Technologies utilisées
- **PHP**
- **Symfony**
- **PostgreSQL**
- **DBeaver**
- **PhpStorm**

---

## ✨ Fonctionnalités principales
- Réservation de mini-stages en ligne
- Consultation des établissements disponibles
- Gestion des réservations par les enseignants
- Possibilité de réserver dans un autre établissement
- API sécurisée exposant les données essentielles

---

## 🔒 Sécurité
- Architecture API sécurisée
- Gestion des rôles (élèves / professeurs / responsables)
- Connexion à une base PostgreSQL protégée

---

## 🧰 Installation & lancement
1. Cloner le dépôt :
   bash
   git clone <url-du-repo>

2. Installer les dépendances :
   bash
   composer install
   
3. Configurer l’environnement dans `.env`
4. Lancer les migrations :
   bash
   php bin/console doctrine:migrations:migrate

5. Démarrer le serveur Symfony :
   bash
   symfony server:start

## 👥 Public visé

* Élèves (réservation)
* Professeurs (gestion)
* Responsable d’établissement / M. Mordelais

---

## 📌 État actuel du projet

✅ Développement **en cours**
➡️ Priorité actuelle : développement et sécurisation de l’API

---

## 🧭 Roadmap

* Développement du front web connecté à l’API
* Implémentation d’un tableau de bord administratif
* Export des statistiques
* Authentification multi-établissements
* Notifications automatisées

---

## 🌲 Structure du projet (tree)

### 🧠 Rôle des dossiers

| Dossier | Rôle |
|--------|------|
| **ApiResource** | Déclare quelles entités sont exposées comme ressources REST |
| **Controller** | Contient la logique qui répond aux requêtes HTTP |
| **Entity** | Décrit les objets métier et la structure de la base de données |
| **Repository** | Gère la récupération/filtrage des données (requêtes custom) |
| **DataFixtures** | Génère des données initiales pour tester l’application |
| **Kernel.php** | Lance Symfony et charge les bundles |

### 🏗️ Architecture
```
src
├── ApiResource
├── Controller
├── DataFixtures
│   ├── AcademieFixtures.php
│   ├── AppFixtures.php
│   ├── EleveFixtures.php
│   ├── EtablissementFixtures.php
│   ├── FonctionFixtures.php
│   ├── FormationFixtures.php
│   ├── MinistageFixtures.php
│   ├── ProfilFixtures.php
│   ├── ReservationFixtures.php
│   ├── TypeEtabFixtures.php
│   ├── TypeFormationFixtures.php
│   └── UtilisateurFixtures.php
├── Entity
│   ├── Academie.php
│   ├── Eleve.php
│   ├── Etablissement.php
│   ├── Fonction.php
│   ├── Formation.php
│   ├── Ministage.php
│   ├── Professeur.php
│   ├── Profil.php
│   ├── Reservation.php
│   ├── TypeEtab.php
│   ├── TypeFormation.php
│   └── Utilisateur.php
├── Kernel.php
└── Repository
    ├── AcademieRepository.php
    ├── EleveRepository.php
    ├── EtablissementRepository.php
    ├── FonctionRepository.php
    ├── FormationRepository.php
    ├── MinistageRepository.php
    ├── ProfesseurRepository.php
    ├── ProfilRepository.php
    ├── ReservationRepository.php
    ├── TypeEtabRepository.php
    ├── TypeFormationRepository.php
    └── UtilisateurRepository.php 
```
---

## 👤 Auteur

**BTS SIO SLAM 2 – 2025/2026**
Promotion **TUCANA**

---

## 📢 Contributions

Les contributions sont les bienvenues : issues, suggestions, PR.

---

## ✅ Objectif long terme

Devenir une plateforme de référence pour la gestion des mini-stages inter-établissements.

Si tu veux une version **plus punchy**, **anglaise**, **avec badges**, ou **avec captures**, je peux monter d’un cran. 🔥
