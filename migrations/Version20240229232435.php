<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229232435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billing DROP updated_at, DROP created_at');
        $this->addSql('ALTER TABLE company CHANGE tva tva DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE tva tva VARCHAR(6) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE tva tva NUMERIC(4, 2) NOT NULL');
        $this->addSql('ALTER TABLE company CHANGE tva tva NUMERIC(4, 2) NOT NULL');
        $this->addSql('ALTER TABLE billing ADD updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
