<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221210185447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER INDEX idx_c76bb9bb4584665a RENAME TO IDX_477ACEB64584665A');
        $this->addSql('ALTER INDEX idx_c76bb9bb38248176 RENAME TO IDX_477ACEB638248176');
        $this->addSql('ALTER INDEX idx_c76bb9bb1252c1e9 RENAME TO IDX_477ACEB61252C1E9');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E9355EDACC');
        $this->addSql('DROP INDEX IDX_1483A5E9355EDACC');
        $this->addSql('ALTER TABLE users RENAME COLUMN congressus_user_informations_id TO congressus_user_information_id');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9355EDACC FOREIGN KEY (congressus_user_information_id) REFERENCES "congressus_user_informations" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1483A5E9355EDACC ON users (congressus_user_information_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "users" DROP CONSTRAINT fk_1483a5e9355edacc');
        $this->addSql('DROP INDEX idx_1483a5e9355edacc');
        $this->addSql('ALTER TABLE "users" RENAME COLUMN congressus_user_information_id TO congressus_user_informations_id');
        $this->addSql('ALTER TABLE "users" ADD CONSTRAINT fk_1483a5e9355edacc FOREIGN KEY (congressus_user_informations_id) REFERENCES congressus_user_informations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_1483a5e9355edacc ON "users" (congressus_user_informations_id)');
        $this->addSql('ALTER INDEX idx_477aceb61252c1e9 RENAME TO idx_c76bb9bb1252c1e9');
        $this->addSql('ALTER INDEX idx_477aceb638248176 RENAME TO idx_c76bb9bb38248176');
        $this->addSql('ALTER INDEX idx_477aceb64584665a RENAME TO idx_c76bb9bb4584665a');
    }
}
