<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124155116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_catalog ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE company_catalog ADD CONSTRAINT FK_3B7E28904584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3B7E28904584665A ON company_catalog (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE company_catalog DROP CONSTRAINT FK_3B7E28904584665A');
        $this->addSql('DROP INDEX IDX_3B7E28904584665A');
        $this->addSql('ALTER TABLE company_catalog DROP product_id');
    }
}
