<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221126191811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "products_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "products" (id INT NOT NULL, currency_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(65535) NULL, price_minor_amount INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A28A69C31 ON "products" (currency_id)');
        $this->addSql('ALTER TABLE "products" ADD CONSTRAINT FK_B3BA5A5A28A69C31 FOREIGN KEY (currency_id) REFERENCES "currencies" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "products_id_seq" CASCADE');
        $this->addSql('ALTER TABLE "products" DROP CONSTRAINT FK_B3BA5A5A28A69C31');
        $this->addSql('DROP TABLE "products"');
    }
}
