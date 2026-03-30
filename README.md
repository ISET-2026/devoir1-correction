** Installer ce projet de developpement **

1. Cloner le projet (git clone <url_du_projet>)
2. Exécuter la commande composer install a partir du dossier du projet (pour installer les dépendances)
3. Adapter le fichier .env (votre login, votre mot de passe, votre base de données, etc)
4. Exécuter la commande php bin/console doctrine:database:create (pour créer la base de données)
5. Exécuter la commande php bin/console doctrine:migrations:migrate (pour créer les tables)
6. Exécuter la commande php bin/console server:start (pour démarrer le serveur)    

