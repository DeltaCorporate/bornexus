<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240216212912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE billing (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, users_id INT NOT NULL, status VARCHAR(25) NOT NULL, type VARCHAR(25) NOT NULL, emited_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', payment_method VARCHAR(25) DEFAULT NULL, discount NUMERIC(10, 0) DEFAULT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_EC224CAA979B1AD6 (company_id), INDEX IDX_EC224CAA67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billing_company_catalog (id INT AUTO_INCREMENT NOT NULL, billing_id INT NOT NULL, company_catalog_id INT DEFAULT NULL, discount NUMERIC(10, 0) NOT NULL, quantity INT NOT NULL, INDEX IDX_6EF3CB873B025C87 (billing_id), INDEX IDX_6EF3CB8771B28F6A (company_catalog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_64C19C1979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, siret VARCHAR(14) NOT NULL, zip VARCHAR(5) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, country VARCHAR(60) NOT NULL, website VARCHAR(2048) DEFAULT NULL, paypal_id VARCHAR(255) DEFAULT NULL, stripe_id VARCHAR(255) DEFAULT NULL, iban VARCHAR(34) DEFAULT NULL, tva TINYINT(1) NOT NULL, tva_reason VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_catalog (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, product_id INT NOT NULL, margin NUMERIC(10, 0) NOT NULL, INDEX IDX_3B7E2890979B1AD6 (company_id), INDEX IDX_3B7E28904584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, company_id INT NOT NULL, supplier_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price NUMERIC(10, 0) NOT NULL, published TINYINT(1) NOT NULL, stock INT NOT NULL, tva NUMERIC(10, 0) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04AD979B1AD6 (company_id), INDEX IDX_D34A04AD2ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, started_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) NOT NULL, website VARCHAR(2048) DEFAULT NULL, INDEX IDX_9B2A6C7E979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(45) DEFAULT NULL, lastname VARCHAR(45) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, country VARCHAR(2) NOT NULL, zip VARCHAR(20) DEFAULT NULL, verification_token VARCHAR(255) DEFAULT NULL, verified_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE billing ADD CONSTRAINT FK_EC224CAA979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE billing ADD CONSTRAINT FK_EC224CAA67B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE billing_company_catalog ADD CONSTRAINT FK_6EF3CB873B025C87 FOREIGN KEY (billing_id) REFERENCES billing (id)');
        $this->addSql('ALTER TABLE billing_company_catalog ADD CONSTRAINT FK_6EF3CB8771B28F6A FOREIGN KEY (company_catalog_id) REFERENCES company_catalog (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_catalog ADD CONSTRAINT FK_3B7E2890979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_catalog ADD CONSTRAINT FK_3B7E28904584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE supplier ADD CONSTRAINT FK_9B2A6C7E979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billing DROP FOREIGN KEY FK_EC224CAA979B1AD6');
        $this->addSql('ALTER TABLE billing DROP FOREIGN KEY FK_EC224CAA67B3B43D');
        $this->addSql('ALTER TABLE billing_company_catalog DROP FOREIGN KEY FK_6EF3CB873B025C87');
        $this->addSql('ALTER TABLE billing_company_catalog DROP FOREIGN KEY FK_6EF3CB8771B28F6A');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1979B1AD6');
        $this->addSql('ALTER TABLE company_catalog DROP FOREIGN KEY FK_3B7E2890979B1AD6');
        $this->addSql('ALTER TABLE company_catalog DROP FOREIGN KEY FK_3B7E28904584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD979B1AD6');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD2ADD6D8C');
        $this->addSql('ALTER TABLE supplier DROP FOREIGN KEY FK_9B2A6C7E979B1AD6');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649979B1AD6');
        $this->addSql('DROP TABLE billing');
        $this->addSql('DROP TABLE billing_company_catalog');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE company_catalog');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
