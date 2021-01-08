<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201219133120 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE identity_access_access_tokens (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', client_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', scopes LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', revoked TINYINT(1) NOT NULL, created_on DATETIME NOT NULL, updated_on DATETIME NOT NULL, expires_on DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE identity_access_clients (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, secret VARCHAR(255) NOT NULL, redirect_uri VARCHAR(255) DEFAULT NULL, active TINYINT(1) NOT NULL, confidential TINYINT(1) NOT NULL, created_on DATETIME NOT NULL, updated_on DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE identity_access_refresh_tokens (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', access_token_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', revoked TINYINT(1) NOT NULL, created_on DATETIME NOT NULL, updated_on DATETIME NOT NULL, expires_on DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE identity_access_users (id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', full_name VARCHAR(220) NOT NULL, username VARCHAR(220) NOT NULL, email VARCHAR(220) NOT NULL, password VARCHAR(220) NOT NULL, created_on DATETIME NOT NULL, updated_on DATETIME NOT NULL, UNIQUE INDEX UNIQ_C1AA95EFF85E0677 (username), UNIQUE INDEX UNIQ_C1AA95EFE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE identity_access_access_tokens');
        $this->addSql('DROP TABLE identity_access_clients');
        $this->addSql('DROP TABLE identity_access_refresh_tokens');
        $this->addSql('DROP TABLE identity_access_users');
    }
}
