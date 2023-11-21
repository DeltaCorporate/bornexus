<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231121214806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billings DROP user_id');
        $this->addSql('ALTER TABLE categories DROP CONSTRAINT fk_3af3466838b53c32');
        $this->addSql('DROP INDEX idx_3af3466838b53c32');
        $this->addSql('ALTER TABLE categories RENAME COLUMN company_id_id TO company_id');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT FK_3AF34668979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3AF34668979B1AD6 ON categories (company_id)');
        $this->addSql('ALTER TABLE company_catalog DROP CONSTRAINT fk_3b7e289038b53c32');
        $this->addSql('DROP INDEX idx_3b7e289038b53c32');
        $this->addSql('ALTER TABLE company_catalog RENAME COLUMN company_id_id TO company_id');
        $this->addSql('ALTER TABLE company_catalog ADD CONSTRAINT FK_3B7E2890979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3B7E2890979B1AD6 ON company_catalog (company_id)');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT fk_b3ba5a5a9777d11e');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT fk_b3ba5a5a38b53c32');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT fk_b3ba5a5aa65f9c7d');
        $this->addSql('DROP INDEX idx_b3ba5a5aa65f9c7d');
        $this->addSql('DROP INDEX idx_b3ba5a5a38b53c32');
        $this->addSql('DROP INDEX idx_b3ba5a5a9777d11e');
        $this->addSql('ALTER TABLE products ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE products ADD company_id INT NOT NULL');
        $this->addSql('ALTER TABLE products ADD supplier_id INT NOT NULL');
        $this->addSql('ALTER TABLE products DROP category_id_id');
        $this->addSql('ALTER TABLE products DROP company_id_id');
        $this->addSql('ALTER TABLE products DROP supplier_id_id');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES suppliers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A12469DE2 ON products (category_id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A979B1AD6 ON products (company_id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A2ADD6D8C ON products (supplier_id)');
        $this->addSql('ALTER TABLE suppliers DROP CONSTRAINT fk_ac28b95c38b53c32');
        $this->addSql('DROP INDEX idx_ac28b95c38b53c32');
        $this->addSql('ALTER TABLE suppliers RENAME COLUMN company_id_id TO company_id');
        $this->addSql('ALTER TABLE suppliers ADD CONSTRAINT FK_AC28B95C979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_AC28B95C979B1AD6 ON suppliers (company_id)');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT fk_8d93d64938b53c32');
        $this->addSql('DROP INDEX idx_8d93d64938b53c32');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN company_id_id TO company_id');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649979B1AD6 FOREIGN KEY (company_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D649979B1AD6 ON "user" (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE categories DROP CONSTRAINT FK_3AF34668979B1AD6');
        $this->addSql('DROP INDEX IDX_3AF34668979B1AD6');
        $this->addSql('ALTER TABLE categories RENAME COLUMN company_id TO company_id_id');
        $this->addSql('ALTER TABLE categories ADD CONSTRAINT fk_3af3466838b53c32 FOREIGN KEY (company_id_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_3af3466838b53c32 ON categories (company_id_id)');
        $this->addSql('ALTER TABLE suppliers DROP CONSTRAINT FK_AC28B95C979B1AD6');
        $this->addSql('DROP INDEX IDX_AC28B95C979B1AD6');
        $this->addSql('ALTER TABLE suppliers RENAME COLUMN company_id TO company_id_id');
        $this->addSql('ALTER TABLE suppliers ADD CONSTRAINT fk_ac28b95c38b53c32 FOREIGN KEY (company_id_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_ac28b95c38b53c32 ON suppliers (company_id_id)');
        $this->addSql('ALTER TABLE billings ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A12469DE2');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A979B1AD6');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A2ADD6D8C');
        $this->addSql('DROP INDEX IDX_B3BA5A5A12469DE2');
        $this->addSql('DROP INDEX IDX_B3BA5A5A979B1AD6');
        $this->addSql('DROP INDEX IDX_B3BA5A5A2ADD6D8C');
        $this->addSql('ALTER TABLE products ADD category_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE products ADD company_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE products ADD supplier_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE products DROP category_id');
        $this->addSql('ALTER TABLE products DROP company_id');
        $this->addSql('ALTER TABLE products DROP supplier_id');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT fk_b3ba5a5a9777d11e FOREIGN KEY (category_id_id) REFERENCES categories (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT fk_b3ba5a5a38b53c32 FOREIGN KEY (company_id_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT fk_b3ba5a5aa65f9c7d FOREIGN KEY (supplier_id_id) REFERENCES suppliers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b3ba5a5aa65f9c7d ON products (supplier_id_id)');
        $this->addSql('CREATE INDEX idx_b3ba5a5a38b53c32 ON products (company_id_id)');
        $this->addSql('CREATE INDEX idx_b3ba5a5a9777d11e ON products (category_id_id)');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649979B1AD6');
        $this->addSql('DROP INDEX IDX_8D93D649979B1AD6');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN company_id TO company_id_id');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d64938b53c32 FOREIGN KEY (company_id_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8d93d64938b53c32 ON "user" (company_id_id)');
        $this->addSql('ALTER TABLE company_catalog DROP CONSTRAINT FK_3B7E2890979B1AD6');
        $this->addSql('DROP INDEX IDX_3B7E2890979B1AD6');
        $this->addSql('ALTER TABLE company_catalog RENAME COLUMN company_id TO company_id_id');
        $this->addSql('ALTER TABLE company_catalog ADD CONSTRAINT fk_3b7e289038b53c32 FOREIGN KEY (company_id_id) REFERENCES companies (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_3b7e289038b53c32 ON company_catalog (company_id_id)');
    }
}
