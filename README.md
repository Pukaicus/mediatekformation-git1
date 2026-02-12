MediaTek86 - Gestion de formations en ligne
Dépôt d'origine
Ce projet est un fork de l'application originale disponible ici : https://github.com/CNED-SLAM/mediatekformation.git Vous y trouverez la présentation détaillée de l'application initiale.

Fonctionnalités ajoutées
Dans le cadre de cet atelier, j'ai développé les modules suivants :

Interface d'administration sécurisée : Accès restreint pour la gestion des contenus.

Gestion complète des formations CRUD : Possibilité d'ajouter, modifier ou supprimer des formations.

Gestion des Playlists : Création et édition de playlists, avec la possibilité d'y affecter des formations.

Système de Catégories : Ajout et suppression de catégories pour un meilleur filtrage des vidéos.

Optimisation de la navigation : Tri des formations par date et filtrage multicritères.

Installation et utilisation en local
Pour installer l'application sur votre environnement de travail WAMP :

Cloner le dépôt :

Bash
git clone https://github.com/Pukaicus/mediatekformation-git1.git
Installer les dépendances PHP :

Bash
composer install
Configurer la base de données :

Renommez le fichier .env.test en .env ou créez un fichier .env.local.

Modifiez la ligne DATABASE_URL avec vos identifiants locaux.

Lancer le serveur Symfony :

Bash
symfony server:start
Test de l'application en ligne
L'application est déployée et consultable à l'adresse suivante :  http://mediatek-lukas.infinityfree.me

Note technique : Les miniatures des formations peuvent apparaître grisées en raison des restrictions de l'hébergeur gratuit sur les requêtes API YouTube.

Informations de sécurité
Les identifiants de connexion administrateur ne sont pas fournis dans ce README pour des raisons de sécurité. Veuillez vous référer à la fiche de réalisation professionnelle jointe pour les tests de la partie admin.
