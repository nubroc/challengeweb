# Challenge Web : Creation of a Banking Application

## Group: n°7  

## - Instructions for deploying the Banking site:
    0 - You can check wireframe in /wireframe folder.

    1 - git clone https://github.com/nubroc/challengeweb.git

    2 - Install dependencies with compose install

    3 - connect this DB in the .env
      - Do a php bin/console doctrine:database:create
      - php bin/console doctrine:migrations:migrate
        or
      - deploy the DB from the postgres.sql file

    4 - and create a symfony serve

### - Registration: Allow a user to register by providing the following information
    ✅ following information:         
        o Last name
        o First name
        o Phone number       
        o Email address              
        o Password  

### - Login: Authentication via email address and password.     
    ✅ Roles :         
        o Standard users: Customers.         
        o Administrators: Account management and supervision.


### Bank account management
    ✅ Account creation: Each user can create up to five (5) bank accounts with :
        o Unique account number (automatically generated).
        o Account type (current, savings).
        o Initial balance.

    ✅ Management rules:
        o A savings account cannot be opened without an initial balance of at least €10.
        o A current account authorizes an overdraft of €400.
        o A customer can close his account
        o Account consultation : View account information.

### Banking Transactions
    ✅ CRUD: 
        o Deposit: Add a specified amount to an account.
        o Withdraw: Subtract a specified amount (within the balance limit).
        o Transfer: Transfer money between two accounts.

    ✅ Transaction history:
        o Date and time.
        o Transaction type (deposit, withdrawal, transfer).
        o Amount.
        o Status (successful/cancelled).

### Administrator management
    ✅ Admin:    
        o View Users: List of registered users.
        o Transaction supervision : Access to transaction history.
        o Account Blocking/Unblocking: In case of suspicious transactions.
        o Transfer transaction cancellation