<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122161609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__workout_plan AS SELECT id, description FROM workout_plan');
        $this->addSql('DROP TABLE workout_plan');
        $this->addSql('CREATE TABLE workout_plan (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, description VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_A5D45801F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO workout_plan (id, description) SELECT id, description FROM __temp__workout_plan');
        $this->addSql('DROP TABLE __temp__workout_plan');
        $this->addSql('CREATE INDEX IDX_A5D45801F675F31B ON workout_plan (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__workout_plan AS SELECT id, description FROM workout_plan');
        $this->addSql('DROP TABLE workout_plan');
        $this->addSql('CREATE TABLE workout_plan (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO workout_plan (id, description) SELECT id, description FROM __temp__workout_plan');
        $this->addSql('DROP TABLE __temp__workout_plan');
    }
}
