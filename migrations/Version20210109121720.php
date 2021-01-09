<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210109121720 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE identity_access_users ADD active TINYINT(1) NOT NULL, ADD avatar VARCHAR(255) DEFAULT NULL, CHANGE full_name full_name VARCHAR(220) NOT NULL, CHANGE username username VARCHAR(220) NOT NULL, CHANGE email email VARCHAR(220) NOT NULL, CHANGE password password VARCHAR(220) NOT NULL');
        $this->addSql('CREATE INDEX IDX_C1AA95EFF85E0677 ON identity_access_users (username)');
        $this->addSql('CREATE INDEX IDX_C1AA95EFE7927C74 ON identity_access_users (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_C1AA95EFF85E0677 ON identity_access_users');
        $this->addSql('DROP INDEX IDX_C1AA95EFE7927C74 ON identity_access_users');
        $this->addSql('ALTER TABLE identity_access_users DROP active, DROP avatar, CHANGE full_name full_name VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE username username VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
