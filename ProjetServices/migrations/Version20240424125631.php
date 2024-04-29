<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424125631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD user_address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD252D06999 FOREIGN KEY (user_address_id) REFERENCES user_address (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD252D06999 ON service (user_address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD252D06999');
        $this->addSql('DROP INDEX IDX_E19D9AD252D06999 ON service');
        $this->addSql('ALTER TABLE service DROP user_address_id');
    }
}
