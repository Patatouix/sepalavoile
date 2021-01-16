<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105085246 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_categorie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_categorie_article (article_categorie_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_94A2D4396FB990BC (article_categorie_id), INDEX IDX_94A2D4397294869C (article_id), PRIMARY KEY(article_categorie_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_categorie_article ADD CONSTRAINT FK_94A2D4396FB990BC FOREIGN KEY (article_categorie_id) REFERENCES article_categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_categorie_article ADD CONSTRAINT FK_94A2D4397294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_categorie_article DROP FOREIGN KEY FK_94A2D4396FB990BC');
        $this->addSql('DROP TABLE article_categorie');
        $this->addSql('DROP TABLE article_categorie_article');
    }
}
