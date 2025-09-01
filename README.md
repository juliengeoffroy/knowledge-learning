# 🎓 Knowledge Learning

Projet Symfony de plateforme d'apprentissage en ligne pour l’organisme fictif **KNOWLEDGE**.

## 📌 Objectifs

Créer une application Symfony permettant :
- La navigation dans des cours organisés par thèmes
- L’achat de cours ou de leçons
- Le suivi de progression et la validation des leçons
- La génération automatique de certificats PDF
- Une interface d'administration (utilisateurs, cours, certificats…)

## 🧰 Technologies utilisées

- PHP 8.2
- Symfony 6.3
- Doctrine ORM
- Twig
- Bootstrap / CSS personnalisée
- Stripe (mode sandbox)
- Mailer (activation de compte)
- PHPUnit (tests unitaires)
- Git / GitHub

## 📚 Fonctionnalités principales

- ✅ Authentification sécurisée avec rôles `ROLE_USER` et `ROLE_ADMIN`
- ✅ Création et activation de comptes par e-mail
- ✅ Visualisation des thèmes, cours et leçons
- ✅ Achat de cours ou leçon (via Stripe)
- ✅ Suivi de progression dans les leçons
- ✅ Génération automatique des certificats PDF (100% progression)
- ✅ Back-office administrateur (gestion des entités)
- ✅ Tests unitaires (Entity / Controller / Fixtures)
- ✅ Design personnalisé + responsive

## 🔐 Accès

- Admin : `admin@kl.com` / `password`
- Utilisateur : `user@kl.com` / `password`

> Les comptes sont créés via fixtures.

## 🧪 Lancer le projet localement

```bash
# Cloner le projet
git clone https://github.com/ton_compte/knowledge-learning.git
cd knowledge-learning

# Installer les dépendances
composer install
npm install
npm run build

# Configurer le fichier .env.local
DATABASE_URL="mysql://root:@127.0.0.1:3306/knowledge_learning?serverVersion=8.0"

# Créer la base de données
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Charger les fixtures
php bin/console doctrine:fixtures:load

# Lancer le serveur
symfony server:start


## 📸 Captures d’écran

### Page d’accueil
Affichage des thèmes proposés sur la page d’accueil.
![Accueil 1](docs/captures/acceuil_1.png)
![Accueil 2](docs/captures/acceuil_2.png)
![Accueil 3](docs/captures/acceuil_3.png)

---

### Vue d’un cours
Détail d’un cours avec ses leçons.
![Cours Détail 1](docs/captures/cours_detail_1.png)
![Cours Détail 2](docs/captures/cours_detail_2.png)
![Cours Détail 3](docs/captures/cours_detail_3.png)
![Cours Détail 4](docs/captures/cours_detail_4.png)
![Cours Détail 5](docs/captures/cours_detail_5.png)
![Cours Détail 6](docs/captures/cours_detail_6.png)

---

### Achat de cours
Capture de l’action d’achat d’un cours.
![Cours Achat](docs/captures/cours_acheter.png)

---

### Mes certificats
Liste des certificats avec téléchargement PDF.
![Certificats](docs/captures/certificats.png)

---

### Interface d’administration
Vue complète de l’interface admin (gestion utilisateurs, cours, etc.).
![Admin 1](docs/captures/admin_1.png)
![Admin 2](docs/captures/admin_2.png)
![Admin 3](docs/captures/admin_3.png)
![Admin 4](docs/captures/admin_4.png)
![Admin 5](docs/captures/admin_5.png)

---

### Paiement avec Stripe
Affichage de la page de paiement.
![Stripe Paiement](docs/captures/stripe_paiement.png)


## 🔗 Liens utiles

- 📄 [Documentation PDF](docs/documentation_knowledge_learning.pdf)
- 🎞️ [Slides de présentation](docs/slides_presentation.pdf)



👤 Auteurs:

-Julien GEOFFROY

-CEF Learning - Projet de validation - Août 2025

-© 2025 KNOWLEDGE LEARNING — Tous droits réservés

