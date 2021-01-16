<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

use App\Entity\ProduitType;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201230094113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO produit_type (nom, slug) VALUES ("' . ProduitType::PRODUIT_TYPE_EVENT_NAME . '", "' . ProduitType::PRODUIT_TYPE_EVENT_SLUG . '")');
        $this->addSql('INSERT INTO produit_type (nom, slug) VALUES ("' . ProduitType::PRODUIT_TYPE_DONATION_NAME . '", "' . ProduitType::PRODUIT_TYPE_DONATION_SLUG . '")');
        $this->addSql('INSERT INTO produit_type (nom, slug) VALUES ("' . ProduitType::PRODUIT_TYPE_ADHESION_NAME . '", "' . ProduitType::PRODUIT_TYPE_ADHESION_SLUG . '")');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE produit_type');
    }
}
