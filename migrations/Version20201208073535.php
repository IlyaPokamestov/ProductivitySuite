<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201208073535 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consumer ALTER name_username TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE consumer ALTER name_first_name TYPE VARCHAR(150)');
        $this->addSql('ALTER TABLE consumer ALTER name_last_name TYPE VARCHAR(150)');
        $this->addSql('ALTER TABLE consumer ALTER email_email TYPE VARCHAR(150)');
        $this->addSql('ALTER TABLE consumer ALTER status_status TYPE VARCHAR(30)');
        $this->addSql('ALTER TABLE list ALTER name TYPE VARCHAR(150)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consumer ALTER name_username TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE consumer ALTER name_first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE consumer ALTER name_last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE consumer ALTER email_email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE consumer ALTER status_status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE list ALTER name TYPE VARCHAR(255)');
    }
}
