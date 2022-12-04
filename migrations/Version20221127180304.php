<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221127180304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD association_id INT NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9EFB9C8A5 FOREIGN KEY (association_id) REFERENCES "associations" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1483A5E9EFB9C8A5 ON users (association_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "users" DROP CONSTRAINT FK_1483A5E9EFB9C8A5');
        $this->addSql('DROP INDEX IDX_1483A5E9EFB9C8A5');
        $this->addSql('ALTER TABLE "users" DROP association_id');
    }
}
