<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251210145448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visite ADD commentaire VARCHAR(255) NOT NULL, ADD tuteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB86EC68D8 FOREIGN KEY (tuteur_id) REFERENCES tuteur (id)');
        $this->addSql('CREATE INDEX IDX_B09C8CBB86EC68D8 ON visite (tuteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB86EC68D8');
        $this->addSql('DROP INDEX IDX_B09C8CBB86EC68D8 ON visite');
        $this->addSql('ALTER TABLE visite DROP commentaire, DROP tuteur_id');
    }
}
