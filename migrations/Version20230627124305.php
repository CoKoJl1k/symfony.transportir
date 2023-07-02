<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs! Version20230627124305
 */
final class Version20230627124305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('create table users
        (
            id                int unsigned auto_increment primary key,
            name              varchar(255) not null,
            email             varchar(255) not null,
            password          varchar(255) not null,
            roles             json  null,
            token             varchar(255) not null,
            created_at        timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at        timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            constraint users_email_unique  unique (email)
        ) ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users');
    }
}
