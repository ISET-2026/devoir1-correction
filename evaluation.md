Parfait 👌
Comme vos étudiants ont déjà réalisé :

* **TP1 : Introduction Symfony** (routing, contrôleurs, vues Twig, structure projet)
* **TP2 : Formulaires & Relations** (FormType, validation, Doctrine, relations)

Je vous propose un **TP d’évaluation à la maison** qui mobilise **TOUS les concepts** de manière cohérente et professionnelle.

---

# 🎓 TP ÉVALUATION – Symfony

## 📚 Application de gestion de projets académiques

---

## 🎯 Contexte

Vous devez développer une application web permettant de gérer des **projets académiques universitaires**.

Un projet est encadré par un enseignant et peut impliquer plusieurs étudiants.

---

# 🧩 Partie 1 – Modélisation & Base de données (Doctrine)

## 📌 Entités à créer

### 1️⃣ Enseignant

* id
* nom
* email
* grade

### 2️⃣ Etudiant

* id
* nom
* email
* niveau (L1, L2, L3…)

### 3️⃣ Projet

* id
* titre
* description
* dateDebut
* dateFin
* statut (En préparation, En cours, Terminé)

---

## 🔗 Relations

* Un **enseignant** peut encadrer plusieurs projets
  → OneToMany

* Un **projet** peut contenir plusieurs étudiants
  → ManyToMany

---

### 🎯 Attendus

* Création des entités via `make:entity`
* Configuration correcte des relations
* Migration générée et exécutée
* Base de données fonctionnelle

---

# 🧾 Partie 2 – CRUD complet (Contrôleurs + Twig)

## 📌 À réaliser pour l’entité Projet :

* ✔ Liste des projets
* ✔ Détail d’un projet
* ✔ Création d’un projet
* ✔ Modification
* ✔ Suppression

Interface claire avec Twig.

---

## 💡 Contraintes obligatoires

* Affichage des projets dans un tableau HTML
* Affichage :

  * nom enseignant
  * nombre d’étudiants inscrits
* Colorer le statut :

  * 🟢 Terminé
  * 🟡 En cours
  * 🔵 En préparation

---

# 🧠 Partie 3 – Formulaires & Validation

## 📌 Créer un FormType pour :

* ProjetType
* EtudiantType

---

## 🎯 Validation obligatoire :

* Titre obligatoire (min 5 caractères)
* Email valide
* DateFin ≥ DateDebut
* Un projet doit contenir au moins 1 étudiant

Utiliser les **annotations de validation**.

---

# 🔎 Partie 4 – Recherche & Filtrage

Sur la page liste des projets :

* 🔍 Recherche par titre
* 📌 Filtrer par statut

Implémentation via QueryBuilder.

---

# 🎨 Partie 5 – Interface utilisateur

* Layout de base avec `base.html.twig`
* Menu de navigation
* Utilisation de Bootstrap
* Messages flash après ajout / modification / suppression

---

# 🔐 BONUS (pour distinction)

* Pagination
* Tri par date
* Message si aucun projet
* Compteur dynamique des projets

---

# 📦 Livrables attendus

* Dépôt GitHub propre
* README contenant :

  * Instructions d’installation
  * Commandes utilisées
  * Schéma des relations
* Commit structuré et progressif

---

# 📝 Grille d’évaluation proposée

| Critère                    | Points |
| -------------------------- | ------ |
| Modélisation & Relations   | 5      |
| CRUD complet fonctionnel   | 6      |
| Formulaires & Validation   | 4      |
| Recherche & Filtrage       | 3      |
| Qualité Twig / UI          | 2      |
| Code propre & organisation | 2      |
| BONUS                      | +3     |

Total : /22 (+3 bonus)

---

# 🎯 Compétences évaluées

* Architecture Symfony
* Doctrine ORM
* Relations entre entités
* FormType & Validation
* Twig avancé
* QueryBuilder
* Organisation projet

---

Si vous le souhaitez, je peux maintenant vous générer :

* 📄 Version PDF prête à distribuer
* 📊 Grille d’évaluation détaillée enseignant
* ✅ Correction complète
* 🎓 Sujet d’examen final plus difficile
* 🧾 Modèle de README attendu
* 🏗 Variante plus simple (si certains étudiants sont en difficulté)

Que souhaitez-vous en priorité ?
