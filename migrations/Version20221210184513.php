<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221210184513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE order_rows_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE order_rows (id INT NOT NULL, product_id INT NOT NULL, currency_id INT NOT NULL, parent_order_id INT NOT NULL, quantity INT NOT NULL, price_minor_amount INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C76BB9BB4584665A ON order_rows (product_id)');
        $this->addSql('CREATE INDEX IDX_C76BB9BB38248176 ON order_rows (currency_id)');
        $this->addSql('CREATE INDEX IDX_C76BB9BB1252C1E9 ON order_rows (parent_order_id)');
        $this->addSql('COMMENT ON COLUMN order_rows.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE order_rows ADD CONSTRAINT FK_C76BB9BB4584665A FOREIGN KEY (product_id) REFERENCES "products" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_rows ADD CONSTRAINT FK_C76BB9BB38248176 FOREIGN KEY (currency_id) REFERENCES "currencies" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_rows ADD CONSTRAINT FK_C76BB9BB1252C1E9 FOREIGN KEY (parent_order_id) REFERENCES "orders" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE order_rows_id_seq CASCADE');
        $this->addSql('ALTER TABLE order_rows DROP CONSTRAINT FK_C76BB9BB4584665A');
        $this->addSql('ALTER TABLE order_rows DROP CONSTRAINT FK_C76BB9BB38248176');
        $this->addSql('ALTER TABLE order_rows DROP CONSTRAINT FK_C76BB9BB1252C1E9');
        $this->addSql('DROP TABLE order_rows');
    }
}
