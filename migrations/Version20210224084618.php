<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224084618 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE galerie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, descritpion LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galerie_galerie_categorie (galerie_id INT NOT NULL, galerie_categorie_id INT NOT NULL, INDEX IDX_35978E97825396CB (galerie_id), INDEX IDX_35978E978CAC3B0B (galerie_categorie_id), PRIMARY KEY(galerie_id, galerie_categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galerie_media (galerie_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_3BAAAE9A825396CB (galerie_id), INDEX IDX_3BAAAE9AEA9FDD75 (media_id), PRIMARY KEY(galerie_id, media_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE galerie_galerie_categorie ADD CONSTRAINT FK_35978E97825396CB FOREIGN KEY (galerie_id) REFERENCES galerie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE galerie_galerie_categorie ADD CONSTRAINT FK_35978E978CAC3B0B FOREIGN KEY (galerie_categorie_id) REFERENCES galerie_categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE galerie_media ADD CONSTRAINT FK_3BAAAE9A825396CB FOREIGN KEY (galerie_id) REFERENCES galerie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE galerie_media ADD CONSTRAINT FK_3BAAAE9AEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE galerie_galerie_categorie DROP FOREIGN KEY FK_35978E97825396CB');
        $this->addSql('ALTER TABLE galerie_media DROP FOREIGN KEY FK_3BAAAE9A825396CB');
        $this->addSql('DROP TABLE galerie');
        $this->addSql('DROP TABLE galerie_galerie_categorie');
        $this->addSql('DROP TABLE galerie_media');
    }
}
