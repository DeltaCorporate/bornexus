<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120155849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE companies_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE companies (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, siret VARCHAR(14) NOT NULL, zip VARCHAR(5) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, country VARCHAR(60) NOT NULL, website TEXT DEFAULT NULL, paypal_id VARCHAR(255) DEFAULT NULL, stripe_id VARCHAR(255) DEFAULT NULL, iban VARCHAR(34) DEFAULT NULL, tva BOOLEAN NOT NULL, tva_reason VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE "user" DROP role');
        $this->addSql('ALTER TABLE "user" ALTER zip TYPE VARCHAR(5)');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN cp�ompany_id TO company_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE companies_id_seq CASCADE');
        $this->addSql('DROP TABLE companies');
        $this->addSql('ALTER TABLE "user" ADD role VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER zip TYPE INT');
        $this->addSql('ALTER TABLE "user" ALTER zip TYPE INT');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN company_id TO "cp�ompany_id"');
    }
}
