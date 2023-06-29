<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs! Version20230628053438
 */
final class Version20230628053438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('create table claims
        (
            id                int unsigned auto_increment primary key,
            text              text not null,
            files             varchar(255)  null,
            user_id           int unsigned not null,
            status_id         tinyint unsigned default 1,
            created_at        timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at        timestamp NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE claims');
    }
}
