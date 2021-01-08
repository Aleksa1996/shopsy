<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210108162644 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE identity_access_roles (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, permissions LONGTEXT NOT NULL COMMENT \'(DC2Type:permissions)\', created_on DATETIME NOT NULL, updated_on DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE identity_access_users_roles (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', role_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_7049C67AA76ED395 (user_id), INDEX IDX_7049C67AD60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE identity_access_users_roles ADD CONSTRAINT FK_7049C67AA76ED395 FOREIGN KEY (user_id) REFERENCES identity_access_users (id)');
        $this->addSql('ALTER TABLE identity_access_users_roles ADD CONSTRAINT FK_7049C67AD60322AC FOREIGN KEY (role_id) REFERENCES identity_access_roles (id)');
        $this->addSql('ALTER TABLE identity_access_users CHANGE full_name full_name VARCHAR(220) NOT NULL, CHANGE username username VARCHAR(220) NOT NULL, CHANGE email email VARCHAR(220) NOT NULL, CHANGE password password VARCHAR(220) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE identity_access_users_roles DROP FOREIGN KEY FK_7049C67AD60322AC');
        $this->addSql('DROP TABLE identity_access_roles');
        $this->addSql('DROP TABLE identity_access_users_roles');
        $this->addSql('ALTER TABLE identity_access_users CHANGE full_name full_name VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE username username VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
