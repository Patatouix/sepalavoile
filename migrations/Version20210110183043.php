<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210110183043 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CBDE7F1C6');
        $this->addSql('DROP INDEX IDX_6A2CA10CBDE7F1C6 ON media');
        $this->addSql('ALTER TABLE media DROP partners_id');
        $this->addSql('ALTER TABLE partners ADD media_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partners ADD CONSTRAINT FK_EFEB5164EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_EFEB5164EA9FDD75 ON partners (media_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media ADD partners_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CBDE7F1C6 FOREIGN KEY (partners_id) REFERENCES partners (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10CBDE7F1C6 ON media (partners_id)');
        $this->addSql('ALTER TABLE partners DROP FOREIGN KEY FK_EFEB5164EA9FDD75');
        $this->addSql('DROP INDEX IDX_EFEB5164EA9FDD75 ON partners');
        $this->addSql('ALTER TABLE partners DROP media_id');
    }
}
