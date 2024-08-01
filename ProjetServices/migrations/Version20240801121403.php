<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801121403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE golden_book ADD user_id INT DEFAULT NULL, CHANGE username username VARCHAR(15) NOT NULL');
        $this->addSql('ALTER TABLE golden_book ADD CONSTRAINT FK_67E09804A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_67E09804A76ED395 ON golden_book (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE golden_book DROP FOREIGN KEY FK_67E09804A76ED395');
        $this->addSql('DROP INDEX UNIQ_67E09804A76ED395 ON golden_book');
        $this->addSql('ALTER TABLE golden_book DROP user_id, CHANGE username username VARCHAR(40) NOT NULL');
    }
}
