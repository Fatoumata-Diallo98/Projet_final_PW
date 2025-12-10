<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration corrigée manuellement pour résoudre les colonnes existantes et les fautes de frappe.
 */
final class Version20251210165010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de la table Visite et correction des clés étrangères.';
    }

    public function up(Schema $schema): void
    {
        // Création de la table Visite (doit être la première chose pour qu'on puisse y ajouter des colonnes)
        // La colonne date doit être créée ici.
        $this->addSql('CREATE TABLE visite (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, date DATETIME NOT NULL, lieu VARCHAR(255) NOT NULL, objectif VARCHAR(255) NOT NULL, remarques LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

        // Ajout de la clé étrangère sur la table Visite (vers Etudiant)
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB DED8AE4B FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('CREATE INDEX IDX_B09C8CBB DED8AE4B ON visite (etudiant_id)');
        
        // La colonne 'password' dans 'tuteur' et 'compte_rendu' dans 'etudiant' sont supposées exister
        // car les migrations précédentes qui les ont créées ont été ignorées ou ont partiellement réussi.
    }

    public function down(Schema $schema): void
    {
        // Supprime la table Visite
        $this->addSql('DROP TABLE visite');
        
        // Lignes initiales pour l'annulation (laissées ici pour la réversibilité complète, même si elles sont inutiles)
        $this->addSql('ALTER TABLE tuteur DROP password');
    }
}