<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201220211729 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE identity_access_access_tokens ADD identifier VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE identity_access_refresh_tokens ADD identifier VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE identity_access_users CHANGE full_name full_name VARCHAR(220) NOT NULL, CHANGE username username VARCHAR(220) NOT NULL, CHANGE email email VARCHAR(220) NOT NULL, CHANGE password password VARCHAR(220) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE identity_access_access_tokens DROP identifier');
        $this->addSql('ALTER TABLE identity_access_refresh_tokens DROP identifier');
        $this->addSql('ALTER TABLE identity_access_users CHANGE full_name full_name VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE username username VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
