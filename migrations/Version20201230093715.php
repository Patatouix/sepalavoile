<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201230093715 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE creneau (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, debut DATETIME NOT NULL, fin DATETIME NOT NULL, INDEX IDX_F9668B5FF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5FF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE produit ADD debut_publication DATETIME DEFAULT NULL, ADD fin_publication DATETIME DEFAULT NULL, DROP date_debut, DROP date_fin');
        $this->addSql('ALTER TABLE produit_type ADD slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE creneau');
        $this->addSql('ALTER TABLE produit ADD date_debut DATETIME DEFAULT NULL, ADD date_fin DATETIME DEFAULT NULL, DROP debut_publication, DROP fin_publication');
        $this->addSql('ALTER TABLE produit_type DROP slug');
    }
}
