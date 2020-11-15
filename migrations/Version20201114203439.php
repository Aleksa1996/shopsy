<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201114203439 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sh_users ADD full_name VARCHAR(220) NOT NULL, ADD username VARCHAR(220) NOT NULL, DROP first_name, DROP last_name, CHANGE email email VARCHAR(220) NOT NULL, CHANGE password password VARCHAR(220) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D0DDA34EF85E0677 ON sh_users (username)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_D0DDA34EF85E0677 ON sh_users');
        $this->addSql('ALTER TABLE sh_users ADD first_name VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD last_name VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP full_name, DROP username, CHANGE email email VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(220) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
