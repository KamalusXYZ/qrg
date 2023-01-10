># Quiz Retro Gaming QRG
>
>### Application PHP sous Symfony
> Cette application a été conçu par Kamal Haddou alias Kamalus. Tout les documents de conception ont été réalisé par Kamal Haddou et peut etre utilisé comme support (MCD, MLD, DICTIONNAIRE DES DONNEES), si vous êtes developpeurs sur le projet demandez les.
>
>### Installation
>#### Prérequis pour les developpeurs
>- PHP (>= 8.1) <br>
    > Il est nécéssaire d'avoir sur sa machine PHP (version 8.1). Pour vérifier si c'est le cas, tapez la conmmande dans l'invite : <br> <br>
    > ``
    > php -v
    > ``
    > <br><br>Si vous ne disposez pas de PHP ou si la version n'est pas à jour rendez vous sur la [documentation PHP](https://www.php.net/manual/fr/install.php) <br><br>
>- Composer (>= 2.3.10) <br>
   > Vous devrez aussi avoir composer sur votre machine, pour vérifier ça, entrez la commande: <br> <br>
   > ``
   > composer -v
   > ``
   > <br> <br>Si un message vous signale que composer n'existe pas, vous devrez l'installer en suivant la [documentation (en anglais)](https://getcomposer.org/doc/00-intro.md).
   > <br><br>
>- Yarn (>= 1.22.19)<br>Pour installer Yarn, la façon la plus simple est de passer par le gestionnaire de paquet NPM. Entrez la commande:<br><br>
   > ``
   npm install --global yarn``<br><br>Si une erreur se produit, vous n'avez probablement pas installer NPM, pour faire ça il est fortement utile d'installer [Node.js](https://nodejs.org/fr/download/) qui inclut [Npm](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm) <br><br>
   > Après l'installation,vérifier que tout s'est bien passé en utilisant cette commande: <br><br>``yarn -v`` <br> <br>
> - Symfony CLI <br>
    > Vous devez installer le client Symfony sur votre machine, pour ça télécharger le sur la page [téléchargement](https://symfony.com/download)  (Attention à la version de l'O.S. et du processeur)
> #### Mise en place sur votre machine
>Pour installer le projet sur votre machine, vous devez cloner le projet dans le repertoire de votre choix grâce à la commande git :<br><br>
> ``
> git clone https://github.com/KamalusXYZ/qrg.git  (demandez un accès si vous n'en avez pas)
> ``<br><br>Installer les dépendances avec les 2 commandes suivantes : <br><br>
> ``
> composer install
> ``<br><br>
> ``
> yarn install
> ``<br><br>
>
> #### Vérification de l'installation
>Contrôlez si tout est Ok avant d'aller plus loin, avec la commande:<br><br>
> ``
> symfony check:requirements
> ``
> <br><br>Si tout est au vert, vous pouvez passer à la suite.
> ## Démarrer l'application
> ### Démarrage
>Pour démarrer l'application, ouvrez un terminal et exécutez la commande :
> ``
> symfony server:start
> ``
> <br><br>Ouvrez un second terminal et exécutez la commande :
> ``
> yarn watch
> ``
> <br><br>L'application sera disponible sur l'URL : http://127.0.0.1:8000/
> <br><br> ***Attention! il faut laisser les invites de commande en permanance ouvert.***<br> <br>

>### Configuration 
>#### Hierarchie des utilisateurs
>### Tips

