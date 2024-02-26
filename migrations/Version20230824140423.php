<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230824140423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE virtual_room ADD user_desc_max_length_tex VARCHAR(255)  NULL');
        $this->addSql('ALTER TABLE virtual_room ADD user_speciality_max_length_text VARCHAR(255) NULL');
     //   $this->addSql('ALTER TABLE virtual_room ALTER background SET NOT NULL');
     //   $this->addSql('ALTER TABLE virtual_room ALTER doc_free SET NOT NULL');
     //   $this->addSql('ALTER TABLE virtual_room ALTER doc_busy SET NOT NULL');
     //   $this->addSql('ALTER TABLE virtual_room ALTER wait SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE virtual_room DROP user_desc_max_length_tex');
        $this->addSql('ALTER TABLE virtual_room DROP user_speciality_max_length_text');
        $this->addSql('ALTER TABLE virtual_room ALTER background DROP NOT NULL');
        $this->addSql('ALTER TABLE virtual_room ALTER doc_free DROP NOT NULL');
        $this->addSql('ALTER TABLE virtual_room ALTER doc_busy DROP NOT NULL');
        $this->addSql('ALTER TABLE virtual_room ALTER wait DROP NOT NULL');
    }
}
