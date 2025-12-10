<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251210154238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visite ADD compte_rendu LONGTEXT DEFAULT NULL, ADD statut VARCHAR(255) NOT NULL, ADD edudiant_id INT NOT NULL');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBBFA44304B FOREIGN KEY (edudiant_id) REFERENCES etudiant (id)');
        $this->addSql('CREATE INDEX IDX_B09C8CBBFA44304B ON visite (edudiant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBBFA44304B');
        $this->addSql('DROP INDEX IDX_B09C8CBBFA44304B ON visite');
        $this->addSql('ALTER TABLE visite DROP compte_rendu, DROP statut, DROP edudiant_id');
    }
}
