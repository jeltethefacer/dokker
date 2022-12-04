<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221201193220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE congressus_user_information_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE congressus_user_information (id INT NOT NULL, congressus_user_id INT NOT NULL, username VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, primary_last_name_prefix VARCHAR(255) DEFAULT NULL, primary_last_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, iban VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE users ADD congressus_user_information_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ALTER association_id DROP DEFAULT');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9355EDACC FOREIGN KEY (congressus_user_information_id) REFERENCES congressus_user_information (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1483A5E9355EDACC ON users (congressus_user_information_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "users" DROP CONSTRAINT FK_1483A5E9355EDACC');
        $this->addSql('DROP SEQUENCE congressus_user_information_id_seq CASCADE');
        $this->addSql('DROP TABLE congressus_user_information');
        $this->addSql('DROP INDEX IDX_1483A5E9355EDACC');
        $this->addSql('ALTER TABLE "users" DROP congressus_user_information_id');
        $this->addSql('ALTER TABLE "users" ALTER association_id SET DEFAULT 1');
    }
}
