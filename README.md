# Challenge Web : Création d’une Application de Gestion Bancaire

## Groupe: n°7  

## • Instruction pour déployer le site Bancaire:
    1 - git clone https://github.com/nubroc/challengeweb.git

    2 - Installer les dépendances avec composer install

    3 - connecter ça BDD dans le .env
      - Faire un php bin/console doctrine:database:create
      - php bin/console doctrine:migrations:migrate
        ou
      - deployer la BDD à partir du fichier postgres.sql

    4 - et faire un symfony serve

### • Inscription : Permettre à un utilisateur de s’inscrire en fournissant les
    ✅ informations suivantes :         
        o Nom
        o prénom
        o Numéro de téléphone       
        o Adresse email              
        o Mot de passe  

### • Connexion : Authentification via adresse email et mot de passe.     
    ✅ Rôles :         
        o Utilisateurs standards : Clients.         
        o Administrateurs : Gestion des comptes et supervision.


### Gestion des Comptes Bancaires
    ✅ Création de Comptes : Chaque utilisateur peut créer jusqu’à cinq (5) comptes bancaires avec :
        o Numéro de compte unique (généré automatiquement).
        o Type de compte (courant, épargne).
        o Solde initial.

    ✅ Règles de gestion :
        o Un compte épargne ne peut pas être ouvert sans un solde initial d’aumoins 10€
        o Un compte courant autorise un découvert de 400€.
        o Un client peut clôturer son compte
        o Consultation des Comptes : Visualisation des informations d’un compte.

### Transactions Bancaires
    ✅ CRUD: 
        o Dépôt : Ajouter un montant spécifié à un compte.
        o Retrait : Soustraire un montant spécifié (dans la limite du solde).
        o Virement : Transférer de l’argent entre deux comptes.

    ✅ Historique des Transactions :
        o Date et heure.
        o Type de transaction (dépôt, retrait, virement).
        o Montant.
        o Statut (réussi/annulé).

### Gestion des Administrateurs
    • Admin:    
        o Visualisation des Utilisateurs : Liste des utilisateurs inscrits.
        o Supervision des Transactions : Accès aux historiques de transactions.
        o Blocage/Déblocage des Comptes : En cas de transactions suspectes.
        o Annulation d’une transaction de virement