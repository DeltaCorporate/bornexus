<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231121220210 extends AbstractMigration
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
        $this->addSql('CREATE SEQUENCE companies_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE company_catalog_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE products_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE session_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE suppliers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE billings (id INT NOT NULL, company_id INT NOT NULL, users_id INT NOT NULL, status VARCHAR(25) NOT NULL, type VARCHAR(25) NOT NULL, emited_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, payment_method VARCHAR(25) DEFAULT NULL, discount NUMERIC(10, 0) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2DE1A7B1979B1AD6 ON billings (company_id)');
        $this->addSql('CREATE INDEX IDX_2DE1A7B167B3B43D ON billings (users_id)');
        $this->addSql('COMMENT ON COLUMN billings.emited_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN billings.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN billings.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE billings_company_catalog (id INT NOT NULL, billing_id INT NOT NULL, company_catalog_id INT NOT NULL, discount NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7E989DF33B025C87 ON billings_company_catalog (billing_id)');
        $this->addSql('CREATE INDEX IDX_7E989DF371B28F6A ON billings_company_catalog (company_catalog_id)');
        $this->addSql('CREATE TABLE categories (id INT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3AF34668979B1AD6 ON categories (company_id)');
        $this->addSql('CREATE TABLE companies (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, siret VARCHAR(14) NOT NULL, zip VARCHAR(5) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, country VARCHAR(60) NOT NULL, website VARCHAR(2048) DEFAULT NULL, paypal_id VARCHAR(255) DEFAULT NULL, stripe_id VARCHAR(255) DEFAULT NULL, iban VARCHAR(34) DEFAULT NULL, tva BOOLEAN NOT NULL, tva_reason VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN companies.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN companies.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE company_catalog (id INT NOT NULL, company_id INT NOT NULL, margin NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3B7E2890979B1AD6 ON company_catalog (company_id)');
        $this->addSql('CREATE TABLE products (id INT NOT NULL, category_id INT NOT NULL, company_id INT NOT NULL, supplier_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, price NUMERIC(10, 0) NOT NULL, published BOOLEAN NOT NULL, stock INT NOT NULL, tva NUMERIC(10, 0) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A12469DE2 ON products (category_id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A979B1AD6 ON products (company_id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A2ADD6D8C ON products (supplier_id)');
        $this->addSql('COMMENT ON COLUMN products.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN products.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE session (id INT NOT NULL, started_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN session.started_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE suppliers (id INT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) NOT NULL, website VARCHAR(2048) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AC28B95C979B1AD6 ON suppliers (company_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, company_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(45) DEFAULT NULL, lastname VARCHAR(45) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, country VARCHAR(2) NOT NULL, zip VARCHAR(20) DEFAULT NULL, verification_token VARCHAR(255) NOT NULL, verified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE INDEX IDX_8D93D649979B1AD6 ON "user" (company_id)');
        $this->addSql('COMMENT ON COLUMN "user".verified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE billings ADD CONSTRAINT FK_2DE1A7B1979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE billings ADD CONSTRAINT FK_2DE1A7B167B3B43D FOREIGN KEY (users_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE billings_company_catalog ADD CONSTRAINT FK_7E989DF33B025C87 FOREIGN KEY (billing_id) REFERENCES billings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE billings_company_catalog ADD CONSTRAINT FK_7E989DF371B28F6A FOREIGN KEY (company_catalog_id) REFERENCES company_catalog (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_catalog ADD CONSTRAINT FK_3B7E2890979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES suppliers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE suppliers ADD CONSTRAINT FK_AC28B95C979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE billings_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE billings_company_catalog_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE categories_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE companies_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE company_catalog_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE products_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE session_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE suppliers_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE billings DROP CONSTRAINT FK_2DE1A7B1979B1AD6');
        $this->addSql('ALTER TABLE billings DROP CONSTRAINT FK_2DE1A7B167B3B43D');
        $this->addSql('ALTER TABLE billings_company_catalog DROP CONSTRAINT FK_7E989DF33B025C87');
        $this->addSql('ALTER TABLE billings_company_catalog DROP CONSTRAINT FK_7E989DF371B28F6A');
        $this->addSql('ALTER TABLE categories DROP CONSTRAINT FK_3AF34668979B1AD6');
        $this->addSql('ALTER TABLE company_catalog DROP CONSTRAINT FK_3B7E2890979B1AD6');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A12469DE2');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A979B1AD6');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A2ADD6D8C');
        $this->addSql('ALTER TABLE suppliers DROP CONSTRAINT FK_AC28B95C979B1AD6');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649979B1AD6');
        $this->addSql('DROP TABLE billings');
        $this->addSql('DROP TABLE billings_company_catalog');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE companies');
        $this->addSql('DROP TABLE company_catalog');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE suppliers');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
