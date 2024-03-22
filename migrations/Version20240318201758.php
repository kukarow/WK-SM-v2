<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318201758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE conference_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE get_data_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE get_token_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE virtual_room_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE conference (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE get_data (id INT NOT NULL, authorization_server VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE get_token (id INT NOT NULL, server_de VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE virtual_room (id INT NOT NULL, ven_id VARCHAR(255) NOT NULL, mac VARCHAR(255) NOT NULL, status VARCHAR(255) DEFAULT NULL, client_address VARCHAR(255) DEFAULT NULL, data_room VARCHAR(255) DEFAULT NULL, video VARCHAR(255) DEFAULT NULL, user_desc BOOLEAN NOT NULL, user_name BOOLEAN NOT NULL, user_photo BOOLEAN NOT NULL, user_speciality BOOLEAN NOT NULL, venue_name BOOLEAN NOT NULL, turn_offin VARCHAR(20) NOT NULL, turn_onin VARCHAR(20) NOT NULL, background VARCHAR(255) NOT NULL, doc_free VARCHAR(255) NOT NULL, doc_busy VARCHAR(255) NOT NULL, wait VARCHAR(255) NOT NULL, user_desc_max_length_tex VARCHAR(255) NOT NULL, user_speciality_max_length_text VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE conference_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE get_data_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE get_token_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE virtual_room_id_seq CASCADE');
        $this->addSql('DROP TABLE conference');
        $this->addSql('DROP TABLE get_data');
        $this->addSql('DROP TABLE get_token');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE virtual_room');
    }
}
