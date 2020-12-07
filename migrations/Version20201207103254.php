<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201207103254 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE list (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE task (id UUID NOT NULL, list_id UUID NOT NULL, description_title VARCHAR(150) NOT NULL, description_note TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE consumer ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE consumer ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE list');
        $this->addSql('DROP TABLE task');
        $this->addSql('ALTER TABLE consumer ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE consumer ALTER id DROP DEFAULT');
    }
}
