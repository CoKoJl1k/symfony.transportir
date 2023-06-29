<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs! Version20230628053441
 */
final class Version20230628053441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('create table comments
        (
            id                int unsigned auto_increment primary key,
            text              text not null,
            files             varchar(255) not null,
            user_id           int not null,
            claims_id          int not null,
            created_at        timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at        timestamp NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comments');
    }
}
