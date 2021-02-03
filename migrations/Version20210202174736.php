<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210202174736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE achat (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, produit_id INT NOT NULL, prix_paye INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_26A98456A76ED395 (user_id), INDEX IDX_26A98456F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, creneau_id INT NOT NULL, user_id INT NOT NULL, quantite_places INT NOT NULL, prix_paye DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_42C849557D0729A9 (creneau_id), INDEX IDX_42C84955A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849557D0729A9 FOREIGN KEY (creneau_id) REFERENCES creneau (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE user_produit');
        $this->addSql('ALTER TABLE produit ADD debut_vente DATETIME DEFAULT NULL, ADD fin_vente DATETIME DEFAULT NULL, DROP debut_publication, DROP fin_publication, CHANGE objectif limite_participation INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_produit (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, produit_id INT NOT NULL, creneau_id INT DEFAULT NULL, quantite INT DEFAULT NULL, montant INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_71A8F22DF347EFB (produit_id), INDEX IDX_71A8F22DA76ED395 (user_id), INDEX IDX_71A8F22D7D0729A9 (creneau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_produit ADD CONSTRAINT FK_71A8F22D7D0729A9 FOREIGN KEY (creneau_id) REFERENCES creneau (id)');
        $this->addSql('ALTER TABLE user_produit ADD CONSTRAINT FK_71A8F22DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_produit ADD CONSTRAINT FK_71A8F22DF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('DROP TABLE achat');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('ALTER TABLE produit ADD debut_publication DATETIME DEFAULT NULL, ADD fin_publication DATETIME DEFAULT NULL, DROP debut_vente, DROP fin_vente, CHANGE limite_participation objectif INT DEFAULT NULL');
    }
}
