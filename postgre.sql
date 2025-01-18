-- Création de la base de données
CREATE DATABASE "bddbanque";

-- Connexion à la base de données
\c "bddbanque";

-- Création de la table "user"
CREATE TABLE "user" (
    "id" SERIAL PRIMARY KEY,
    "email" VARCHAR(180) NOT NULL,
    "roles" JSON NOT NULL,
    "password" VARCHAR(255) NOT NULL,
    "nom" VARCHAR(255) NOT NULL,
    "prenom" VARCHAR(255) NOT NULL,
    "telephone" VARCHAR(20) NOT NULL,
    CONSTRAINT "UNIQ_IDENTIFIER_EMAIL" UNIQUE ("email")
);

-- Création de la table "messenger_messages"
CREATE TABLE "messenger_messages" (
    "id" BIGINT PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    "body" TEXT NOT NULL,
    "headers" TEXT NOT NULL,
    "queue_name" VARCHAR(190) NOT NULL,
    "created_at" TIMESTAMP NOT NULL,
    "available_at" TIMESTAMP NOT NULL,
    "delivered_at" TIMESTAMP,
    CONSTRAINT "IDX_75EA56E0FB7336F0" INDEX ("queue_name"),
    CONSTRAINT "IDX_75EA56E0E3BD61CE" INDEX ("available_at"),
    CONSTRAINT "IDX_75EA56E016BA31DB" INDEX ("delivered_at")
);

-- Création de la table "accounts"
CREATE TABLE "accounts" (
    "id" SERIAL PRIMARY KEY,
    "user_id" INT NOT NULL,
    "account_number" VARCHAR(255) NOT NULL,
    "type" VARCHAR(255) NOT NULL,
    "balance" DOUBLE PRECISION NOT NULL,
    CONSTRAINT "UNIQ_CAC89EACB1A4D127" UNIQUE ("account_number"),
    CONSTRAINT "IDX_CAC89EACA76ED395" INDEX ("user_id"),
    CONSTRAINT "FK_CAC89EACA76ED395" FOREIGN KEY ("user_id") REFERENCES "user" ("id")
);

-- Suppression de la colonne "user_id" dans la table "transaction"
ALTER TABLE "transaction" DROP COLUMN "user_id";
