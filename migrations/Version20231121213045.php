<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231121213045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, domain VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE billings ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE billings ADD CONSTRAINT FK_2DE1A7B1979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE billings ADD CONSTRAINT FK_2DE1A7B119EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2DE1A7B1979B1AD6 ON billings (company_id)');
        $this->addSql('CREATE INDEX IDX_2DE1A7B119EB6921 ON billings (client_id)');
        $this->addSql('ALTER TABLE billings_company_catalog ADD CONSTRAINT FK_7E989DF33B025C87 FOREIGN KEY (billing_id) REFERENCES billings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE billings_company_catalog ADD CONSTRAINT FK_7E989DF371B28F6A FOREIGN KEY (company_catalog_id) REFERENCES company_catalog (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7E989DF33B025C87 ON billings_company_catalog (billing_id)');
        $this->addSql('CREATE INDEX IDX_7E989DF371B28F6A ON billings_company_catalog (company_catalog_id)');
        $this->addSql('ALTER TABLE categories RENAME COLUMN company_id TO company_id_id');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF3466838B53C32 FOREIGN KEY (company_id_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3AF3466838B53C32 ON categories (company_id_id)');
        $this->addSql('ALTER TABLE company_catalog ADD company_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE company_catalog DROP product_id');
        $this->addSql('ALTER TABLE company_catalog DROP company_id');
        $this->addSql('ALTER TABLE company_catalog ADD CONSTRAINT FK_3B7E289038B53C32 FOREIGN KEY (company_id_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3B7E289038B53C32 ON company_catalog (company_id_id)');
        $this->addSql('ALTER TABLE products ADD category_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE products ADD company_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE products ADD supplier_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE products DROP category_id');
        $this->addSql('ALTER TABLE products DROP supplier_id');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A9777D11E FOREIGN KEY (category_id_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A38B53C32 FOREIGN KEY (company_id_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AA65F9C7D FOREIGN KEY (supplier_id_id) REFERENCES suppliers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A9777D11E ON products (category_id_id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A38B53C32 ON products (company_id_id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5AA65F9C7D ON products (supplier_id_id)');
        $this->addSql('ALTER TABLE suppliers RENAME COLUMN company_id TO company_id_id');
        $this->addSql('ALTER TABLE suppliers ADD CONSTRAINT FK_AC28B95C38B53C32 FOREIGN KEY (company_id_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_AC28B95C38B53C32 ON suppliers (company_id_id)');
        $this->addSql('ALTER TABLE "user" ADD company_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D64938B53C32 FOREIGN KEY (company_id_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D64938B53C32 ON "user" (company_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE billings DROP CONSTRAINT FK_2DE1A7B119EB6921');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP TABLE client');
        $this->addSql('ALTER TABLE billings DROP CONSTRAINT FK_2DE1A7B1979B1AD6');
        $this->addSql('DROP INDEX IDX_2DE1A7B1979B1AD6');
        $this->addSql('DROP INDEX IDX_2DE1A7B119EB6921');
        $this->addSql('ALTER TABLE billings DROP client_id');
        $this->addSql('ALTER TABLE billings_company_catalog DROP CONSTRAINT FK_7E989DF33B025C87');
        $this->addSql('ALTER TABLE billings_company_catalog DROP CONSTRAINT FK_7E989DF371B28F6A');
        $this->addSql('DROP INDEX IDX_7E989DF33B025C87');
        $this->addSql('DROP INDEX IDX_7E989DF371B28F6A');
        $this->addSql('ALTER TABLE categories DROP CONSTRAINT FK_3AF3466838B53C32');
        $this->addSql('DROP INDEX IDX_3AF3466838B53C32');
        $this->addSql('ALTER TABLE categories RENAME COLUMN company_id_id TO company_id');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64938B53C32');
        $this->addSql('DROP INDEX IDX_8D93D64938B53C32');
        $this->addSql('ALTER TABLE "user" DROP company_id_id');
        $this->addSql('ALTER TABLE suppliers DROP CONSTRAINT FK_AC28B95C38B53C32');
        $this->addSql('DROP INDEX IDX_AC28B95C38B53C32');
        $this->addSql('ALTER TABLE suppliers RENAME COLUMN company_id_id TO company_id');
        $this->addSql('ALTER TABLE company_catalog DROP CONSTRAINT FK_3B7E289038B53C32');
        $this->addSql('DROP INDEX IDX_3B7E289038B53C32');
        $this->addSql('ALTER TABLE company_catalog ADD company_id INT NOT NULL');
        $this->addSql('ALTER TABLE company_catalog RENAME COLUMN company_id_id TO product_id');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A9777D11E');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A38B53C32');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5AA65F9C7D');
        $this->addSql('DROP INDEX IDX_B3BA5A5A9777D11E');
        $this->addSql('DROP INDEX IDX_B3BA5A5A38B53C32');
        $this->addSql('DROP INDEX IDX_B3BA5A5AA65F9C7D');
        $this->addSql('ALTER TABLE products ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE products ADD supplier_id INT NOT NULL');
        $this->addSql('ALTER TABLE products DROP category_id_id');
        $this->addSql('ALTER TABLE products DROP company_id_id');
        $this->addSql('ALTER TABLE products DROP supplier_id_id');
    }
}
