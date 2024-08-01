<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240730080736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE golden_book (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(40) NOT NULL, text LONGTEXT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD252D06999');
        $this->addSql('ALTER TABLE service CHANGE user_address_id user_address_id INT NOT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD252D06999 FOREIGN KEY (user_address_id) REFERENCES user_address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE golden_book');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD252D06999');
        $this->addSql('ALTER TABLE service CHANGE user_address_id user_address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD252D06999 FOREIGN KEY (user_address_id) REFERENCES user_address (id) ON UPDATE CASCADE');
    }
}
