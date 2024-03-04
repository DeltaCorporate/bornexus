<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304181459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billing ADD amount_paid NUMERIC(10, 3) DEFAULT NULL, ADD checkout_session VARCHAR(400) DEFAULT NULL, ADD uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', CHANGE discount discount INT DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE billing_company_catalog ADD quantity INT NOT NULL, ADD price_ht DOUBLE PRECISION DEFAULT NULL, ADD tva VARCHAR(5) DEFAULT NULL, ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE company_catalog_id company_catalog_id INT DEFAULT NULL, CHANGE discount discount INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE company ADD status VARCHAR(255) NOT NULL, DROP test, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE company_catalog ADD status TINYINT(1) DEFAULT 1 NOT NULL, ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD979B1AD6');
        $this->addSql('DROP INDEX IDX_D34A04AD979B1AD6 ON product');
        $this->addSql('ALTER TABLE product ADD thumbnail VARCHAR(255) NOT NULL, DROP company_id, CHANGE tva tva NUMERIC(4, 2) NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE supplier ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE user ADD city VARCHAR(90) DEFAULT NULL, ADD phone VARCHAR(15) DEFAULT NULL, CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE country country VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company ADD test DOUBLE PRECISION NOT NULL, DROP status, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE product ADD company_id INT NOT NULL, DROP thumbnail, CHANGE tva tva NUMERIC(10, 0) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD979B1AD6 ON product (company_id)');
        $this->addSql('ALTER TABLE billing_company_catalog DROP quantity, DROP price_ht, DROP tva, DROP created_at, DROP updated_at, CHANGE company_catalog_id company_catalog_id INT NOT NULL, CHANGE discount discount NUMERIC(10, 0) NOT NULL');
        $this->addSql('ALTER TABLE supplier DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE company_catalog DROP status, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE category DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE `user` DROP city, DROP phone, CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL, CHANGE country country VARCHAR(2) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE billing DROP amount_paid, DROP checkout_session, DROP uuid, CHANGE discount discount NUMERIC(10, 0) DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
