<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240622131521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD252D06999');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD252D06999 FOREIGN KEY (user_address_id) REFERENCES user_address (id)');
        $this->addSql('ALTER TABLE user_address ADD rentprice INT DEFAULT NULL, ADD real_estate_agency VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD252D06999');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD252D06999 FOREIGN KEY (user_address_id) REFERENCES user_address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_address DROP rentprice, DROP real_estate_agency');
    }
}
