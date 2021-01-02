<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201229135939 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit ADD produit_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC273B707EA FOREIGN KEY (produit_type_id) REFERENCES produit_type (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC273B707EA ON produit (produit_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC273B707EA');
        $this->addSql('DROP INDEX IDX_29A5EC273B707EA ON produit');
        $this->addSql('ALTER TABLE produit DROP produit_type_id');
    }
}
