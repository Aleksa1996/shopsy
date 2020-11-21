<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201019200427 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sh_users (id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_id)\', first_name VARCHAR(220) NOT NULL, last_name VARCHAR(220) NOT NULL, email VARCHAR(220) NOT NULL, password VARCHAR(220) NOT NULL, created_on DATETIME NOT NULL, updated_on DATETIME NOT NULL, UNIQUE INDEX UNIQ_D0DDA34EE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sh_users');
    }
}
