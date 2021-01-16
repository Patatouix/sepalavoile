<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201230212647 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_produit ADD creneau_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_produit ADD CONSTRAINT FK_71A8F22D7D0729A9 FOREIGN KEY (creneau_id) REFERENCES creneau (id)');
        $this->addSql('CREATE INDEX IDX_71A8F22D7D0729A9 ON user_produit (creneau_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_produit DROP FOREIGN KEY FK_71A8F22D7D0729A9');
        $this->addSql('DROP INDEX IDX_71A8F22D7D0729A9 ON user_produit');
        $this->addSql('ALTER TABLE user_produit DROP creneau_id');
    }
}
