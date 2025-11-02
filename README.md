### Pré-requis
Plusieurs paquets sont nécessaires pour réaliser les démonstrations. Le nom de ces derniers dépendra de votre gestionnaire
```shell
sudo apt install apache2 php sqlite3 php-sqlite3 libsqlite3-0 iputils-ping whois
```
Pour pouvoir effectuer l'attaque par inclusion de fichier "A08:2021 Photos Souvenirs", il vous faudra modifier la taille maximale des fichiers téléchargés autorisée. Pour cela il vous faut modifier le fichier `/etc/php/X.X/apa che2/php.ini` où `X.X`représente la version de PHP installée. La directive à modifier est `upload_max_filesize` en y mettant une taille égale au moins à `50M` (Mo).

### Installation
Il vous faudra ensuite cloner le repos GitHub à l'emplacement des hôtes web de Apache2. Le chemin par défaut se situe à `/var/www/html`.
Si vous avez implémentez plusieurs hôte, il vous faudra adapter le chemin d'installation à vous sous-hôtes.

Plusieurs commandes sont ensuite à effectuer pour générer la base de données et accorder les droits en écriture:
Depuis le répertoire local du repos GitHub:
```shell
sudo sqlite3 db/vegetables.db < db/init_db_vegetables.sql
sudo sqlite3 db/users.db < db/init_db_users.sql
```
Puis pour les droits de la base de données et du dossier de téléchargement de fichiers:
```shell
chmod 777 db
chmod 777 db/vegetables.db
mkdir img
chmod 777 img
```

Vous pouvez ensuite démarrer le serveur web Apache2:
```shell
sudo systemctl start apache2
```
Et accéder aux démonstrations à l'adresse de votre hôte apache2.

### Patch
Pour appliquer les patchs, vous pouvez consulter le code source des pages `php`associées aux démonstrations et décommenter les lignes du correctif `//PATCH ...`. Voici la table de correspondance entre les fichiers sources et les démonstrations:
```
├── login.php //A03:2021 Connectez-vous
├── ping.php //A03:2021 Ping!
├── upload.php //A08:2021 Photos Souvenirs
├── vegetables.php //A04:2021 Panier de fruits et légumes
└── whodis.php // A04:2021 Who dis?
```
