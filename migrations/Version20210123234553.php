<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210123234553 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE identity_access_roles ADD active TINYINT(1) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_63171EC15E237E06 ON identity_access_roles (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_63171EC1772E836A ON identity_access_roles (identifier)');
        $this->addSql('CREATE INDEX IDX_63171EC15E237E06 ON identity_access_roles (name)');
        $this->addSql('CREATE INDEX IDX_63171EC1772E836A ON identity_access_roles (identifier)');
        $this->addSql('ALTER TABLE identity_access_users CHANGE full_name full_name VARCHAR(220) NOT NULL, CHANGE username username VARCHAR(220) NOT NULL, CHANGE email email VARCHAR(220) NOT NULL, CHANGE password password VARCHAR(220) NOT NULL, CHANGE active active TINYINT(1) NOT NULL, CHANGE avatar avatar VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_63171EC15E237E06 ON identity_access_roles');
        $this->addSql('DROP INDEX UNIQ_63171EC1772E836A ON identity_access_roles');
        $this->addSql('DROP INDEX IDX_63171EC15E237E06 ON identity_access_roles');
        $this->addSql('DROP INDEX IDX_63171EC1772E836A ON identity_access_roles');
        $this->addSql('ALTER TABLE identity_access_roles DROP active');
        $this->addSql('ALTER TABLE identity_access_users CHANGE full_name full_name VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE username username VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE active active TINYINT(1) NOT NULL, CHANGE avatar avatar VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
