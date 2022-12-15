<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221204195637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "orders_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "orders" (id INT NOT NULL, ordered_by_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E52FFDEE91FF3C4D ON "orders" (ordered_by_id)');
        $this->addSql('COMMENT ON COLUMN "orders".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE "orders" ADD CONSTRAINT FK_E52FFDEE91FF3C4D FOREIGN KEY (ordered_by_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "orders_id_seq" CASCADE');
        $this->addSql('ALTER TABLE "orders" DROP CONSTRAINT FK_E52FFDEE91FF3C4D');
        $this->addSql('DROP TABLE "orders"');
    }
}
