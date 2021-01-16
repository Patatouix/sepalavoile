<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210106082902 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, url LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, facebook_link LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_produit (media_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_48726A6EEA9FDD75 (media_id), INDEX IDX_48726A6EF347EFB (produit_id), PRIMARY KEY(media_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE media_produit ADD CONSTRAINT FK_48726A6EEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_produit ADD CONSTRAINT FK_48726A6EF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media_produit DROP FOREIGN KEY FK_48726A6EEA9FDD75');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE media_produit');
    }
}
