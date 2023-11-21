<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231121013445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE billings_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE billings_company_catalog_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE categories_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE company_catalog_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE products_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE suppliers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE billings (id INT NOT NULL, status VARCHAR(25) NOT NULL, user_id INT NOT NULL, company_id INT NOT NULL, type VARCHAR(25) NOT NULL, emited_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, payment_method VARCHAR(25) DEFAULT NULL, discount NUMERIC(10, 0) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN billings.emited_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN billings.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN billings.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE billings_company_catalog (id INT NOT NULL, billing_id INT NOT NULL, company_catalog_id INT NOT NULL, discount NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE categories (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, company_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE company_catalog (id INT NOT NULL, product_id INT NOT NULL, company_id INT NOT NULL, margin NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE products (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, category_id INT NOT NULL, supplier_id INT NOT NULL, price NUMERIC(10, 0) NOT NULL, published BOOLEAN NOT NULL, stock INT NOT NULL, tva NUMERIC(10, 0) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN products.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN products.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE suppliers (id INT NOT NULL, name VARCHAR(255) NOT NULL, website VARCHAR(2048) DEFAULT NULL, company_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE companies ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE companies ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE companies ALTER website TYPE VARCHAR(2048)');
        $this->addSql('COMMENT ON COLUMN companies.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN companies.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE billings_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE billings_company_catalog_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE categories_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE company_catalog_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE products_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE suppliers_id_seq CASCADE');
        $this->addSql('DROP TABLE billings');
        $this->addSql('DROP TABLE billings_company_catalog');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE company_catalog');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE suppliers');
        $this->addSql('ALTER TABLE companies DROP created_at');
        $this->addSql('ALTER TABLE companies DROP updated_at');
        $this->addSql('ALTER TABLE companies ALTER website TYPE TEXT');
        $this->addSql('ALTER TABLE companies ALTER website TYPE TEXT');
    }
}
