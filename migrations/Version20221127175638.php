<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221127175638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "associations_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "associations" (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE products ALTER description SET NOT NULL');
        $this->addSql('ALTER INDEX idx_b3ba5a5a28a69c31 RENAME TO IDX_B3BA5A5A38248176');
        $this->addSql("INSERT INTO associations (id, name) VALUES (1, 'Cleopatra')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "associations_id_seq" CASCADE');
        $this->addSql('DROP TABLE "associations"');
        $this->addSql('ALTER TABLE "products" ALTER description DROP NOT NULL');
        $this->addSql('ALTER INDEX idx_b3ba5a5a38248176 RENAME TO idx_b3ba5a5a28a69c31');
    }
}
